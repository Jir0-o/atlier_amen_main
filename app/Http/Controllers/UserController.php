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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // capture guest SID BEFORE login happens
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

        Auth::login($user);

        $request->session()->regenerate();

        WishlistController::mergeGuestToUser($oldSid, Auth::id());

        $cartMerge->merge($oldSid, Auth::id(), $request->session()->getId());


        $cartCount = (int) TempCart::where('user_id', Auth::id())->sum('quantity');
        session(['cart_count' => $cartCount]);

        return response()->json([
            'status'   => 'success',
            'message'  => 'Registration successful! You are now logged in.',
            'redirect' => route('index'),
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
