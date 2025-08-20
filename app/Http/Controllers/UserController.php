<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FrontendLoginRequest;
use App\Http\Requests\FrontendRegisterRequest;
use App\Models\TempCart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\CartMergeService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('backend.settings.user_manage');
    }

    public function data(Request $request)
    {
        try {
            $q = User::query()
                ->select([
                    'users.id',
                    'users.first_name',
                    'users.last_name',
                    'users.email',
                    'users.phone',
                    'users.is_active',
                    'users.created_at',
                ])
                // TOTAL SPENT (use grand_total from orders)
                ->addSelect([
                    'money_spent' => Order::selectRaw('COALESCE(SUM(grand_total), 0)')
                        ->whereColumn('orders.user_id', 'users.id'),
                ])
                // TOTAL PRODUCTS PURCHASED (sum of order_items.quantity for this user)
                ->addSelect([
                    'product_count' => OrderItem::selectRaw('COALESCE(SUM(order_items.quantity), 0)')
                        ->join('orders', 'orders.id', '=', 'order_items.order_id')
                        ->whereColumn('orders.user_id', 'users.id'),
                ])
                // LAST PURCHASE DATETIME
                ->addSelect([
                    'last_purchase_at' => Order::selectRaw('MAX(created_at)')
                        ->whereColumn('orders.user_id', 'users.id'),
                ])
                ->latest('users.created_at');

            return DataTables::of($q)
                ->addIndexColumn()
                ->editColumn('money_spent', fn ($u) => number_format((float)($u->money_spent ?? 0), 2))
                ->editColumn('product_count', fn ($u) => (int) ($u->product_count ?? 0))
                ->editColumn('last_purchase_at', fn ($u) =>
                    $u->last_purchase_at
                        ? Carbon::parse($u->last_purchase_at)->format('Y-m-d H:i:s')
                        : '—'
                )
                ->addColumn('status', fn ($u) =>
                    $u->is_active
                        ? '<span class="badge bg-success">Enabled</span>'
                        : '<span class="badge bg-secondary">Disabled</span>'
                )
                ->addColumn('action', function ($u) {
                    $btnClass = $u->is_active ? 'btn-outline-danger' : 'btn-outline-success';
                    $label    = $u->is_active ? 'Disable' : 'Enable';
                    $route    = route('admin.users.toggle', $u->id);
                    $token    = csrf_token();
                    return <<<HTML
                        <form action="{$route}" method="POST" class="user-toggle-form" style="display:inline-block;">
                            <input type="hidden" name="_token" value="{$token}">
                            <input type="hidden" name="_method" value="PATCH">
                            <button type="submit" class="btn btn-sm {$btnClass}">{$label}</button>
                        </form>
                    HTML;
                })
                ->rawColumns(['status','action'])
                ->make(true);

        } catch (\Throwable $e) {
            // Use the proper Log facade
            \Illuminate\Support\Facades\Log::error('Users DataTables error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'message' => 'Server error',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }



    public function toggle(Request $request, User $user)
    {
        $user->is_active = ! $user->is_active;
        $user->save();

        // If we just DISABLED the user, invalidate all sessions & tokens
        if (! $user->is_active) {
            // 1) Rotate remember_token so "remember me" cookies die
            $user->setRememberToken(Str::random(60));
            $user->save();

            // 2) If using Sanctum/Passport, nuke API tokens (ignore if not used)
            if (method_exists($user, 'tokens')) {
                try { $user->tokens()->delete(); } catch (\Throwable $e) {}
            }

            // 3) If session driver = database, delete all their sessions
            try {
                if (config('session.driver') === 'database') {
                    DB::table(config('session.table', 'sessions'))
                        ->where('user_id', $user->getAuthIdentifier())
                        ->delete();
                }
            } catch (\Throwable $e) {
                \Log::warning('Failed to purge sessions for user '.$user->id.': '.$e->getMessage());
            }
        }

        // JSON for AJAX, otherwise redirect with flash
        $msg = 'User '.($user->is_active ? 'enabled' : 'disabled').' successfully.';
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $msg]);
        }
        return back()->with('success', $msg);
    }

    private function csrfToken(): string
    {
        return csrf_token();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FrontendRegisterRequest $request, CartMergeService $cartMerge): JsonResponse
    {
        $oldSid = $request->session()->getId();

        $name = trim($request->input('f_name') . ' ' . $request->input('l_name'));

        $user = User::create([
            'name'       => $name,
            'first_name' => $request->input('f_name'),
            'last_name'  => $request->input('l_name'),
            'email'      => $request->input('email'),
            'country'    => $request->input('country'),
            'password'   => Hash::make($request->input('password')),
        ]);

        event(new Registered($user));


        Auth::login($user);
        $request->session()->regenerate();

        WishlistController::mergeGuestToUser($oldSid, Auth::id());
        $cartMerge->merge($oldSid, Auth::id(), $request->session()->getId());

        $cartCount = (int) TempCart::where('user_id', Auth::id())->sum('quantity');
        session(['cart_count' => $cartCount]);

        // 👉 Redirect frontend to verification notice
        return response()->json([
            'status'     => 'success',
            'message'    => 'Registration successful! We emailed you a verification link.',
            'redirect'   => route('verification.notice'),
            'cart_count' => $cartCount,
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(FrontendLoginRequest $request, CartMergeService $cartMerge): JsonResponse
    {
        // capture guest SID BEFORE attempt
        $oldSid = $request->session()->getId();

        $credentials = $request->only('email', 'password');
        $remember    = (bool) $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Invalid credentials.',
                'errors'  => [
                    'email'    => ['We can’t find a user with those credentials.'],
                    'password' => ['Check your password and try again.'],
                ],
            ], 422);
        }

        if (! Auth::user()->is_active) {
            Auth::logout();
            return response()->json([
                'status'  => 'error',
                'message' => 'Your account is disabled. Please contact support.',
            ], 403);
        }


        $request->session()->regenerate();

        $cartMerge->merge($oldSid, Auth::id(), $request->session()->getId());

        WishlistController::mergeGuestToUser($oldSid, Auth::id());

        // update mini-cart count (optional)
        $cartCount = (int) TempCart::where('user_id', Auth::id())->sum('quantity');
        session(['cart_count' => $cartCount]);

        return response()->json([
            'status'     => 'success',
            'message'    => 'Login successful! Redirecting...',
            'redirect'   => route('index'),
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout successful.',
        ]);
    }
}
