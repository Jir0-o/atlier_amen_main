<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use App\Models\TempCart;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function show(Request $request): View
    {
        $user      = $request->user();
        $userId    = $user?->id;
        $sessionId = $request->session()->getId();

        $orders = $user->orders()
            ->with(['items.work', 'items.workVariant'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $user->load(['shippingAddress','billingAddress']);

        $wishlist = Wishlist::with('work')
            ->forCurrent($userId, $sessionId)
            ->with(['work' => function ($q) {
                $q->withMin('variants', 'price');
            }])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $cart = TempCart::with(['work','workVariant'])
            ->forCurrent($userId, $sessionId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('frontend.auth.profile', [
            'user'     => $user,
            'order'    => $orders,
            'wishlist' => $wishlist,
            'cart'     => $cart,
        ]);
    }
        public function showOrder(Request $request, Order $order)
    {

        abort_if($order->user_id !== $request->user()->id, 403);

        // eager load items + related work + variant
        $order->load('items.work', 'items.workVariant');
        // shape response
        $items = $order->items->map(function ($it) {
            $work      = $it->work;
            $variant   = $it->variant_text ?: optional($it->workVariant)->name;
            $img       = $work?->work_image_low ?? $work?->work_image;

            return [
                'name'         => $work?->name ?? 'Unnamed Artwork',
                'variant'      => $variant,
                'quantity'     => (int) $it->quantity,
                'unit_price'   => (float) $it->unit_price,
                'line_total'   => (float) $it->line_total,
                'image'        => $img ? asset($img) : asset('images/no-image.png'),
                'work_id'      => $work?->id,
                'variant_id'   => $it->work_variant_id,
            ];
        });

        return response()->json([
            'success'          => true,
            'order'            => [
                'id'               => $order->id,
                'total_qty'        => (int) $order->total_qty,
                'subtotal'         => (float) $order->subtotal,
                'shipping_charge'  => (float) $order->shipping_charge,
                'grand_total'      => (float) $order->grand_total,
                'status'           => $order->status,
                'created_at'       => $order->created_at?->format('Y-m-d H:i:s'),
                'shipping'         => [
                    'name'    => trim($order->ship_fname.' '.$order->ship_lname),
                    'address' => $order->ship_address,
                    'city'    => $order->ship_city,
                    'state'   => $order->ship_state,
                    'zip'     => $order->ship_zip,
                    'country' => $order->ship_country,
                ],
                'billing'          => [
                    'name'    => trim($order->bill_fname.' '.$order->bill_lname),
                    'address' => $order->bill_address,
                    'city'    => $order->bill_city,
                    'state'   => $order->bill_state,
                    'zip'     => $order->bill_zip,
                    'country' => $order->bill_country,
                ],
            ],
            'items'            => $items,
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

        public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'first_name'    => ['required','string','max:100'],
            'last_name'     => ['required','string','max:100'],
            'date_of_birth' => ['nullable','date'],
            'username'      => ['nullable','string','max:100', Rule::unique('users','username')->ignore($user->id)],
            'country'       => ['nullable','string','max:255'],
            'phone'         => ['nullable','string','max:50'],
        ]);

        $data['name'] = trim(($data['first_name'] ?? $user->first_name).' '.($data['last_name'] ?? $user->last_name));

        $user->fill($data)->save();

        return back()->with('success', 'Profile updated.');
    }

    public function changePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password'      => ['required','string'],
            'password'              => ['required','string','min:8','confirmed'],
            // expects input fields: password & password_confirmation
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Logout after password change
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('frontend.login')->with('success', 'Password changed. Please log in again.');
    }

    public function changeEmail(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'email'            => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'current_password' => ['required','string'],
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->email = $request->input('email');
        $user->save();

        // Logout after email change
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('frontend.login')->with('success', 'Email changed. Please log in again.');
    }
}
