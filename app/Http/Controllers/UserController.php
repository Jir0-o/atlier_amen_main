<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FrontendLoginRequest;
use App\Http\Requests\FrontendRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
    public function store(FrontendRegisterRequest $request): JsonResponse
    {
        // Build display name (adjust to your schema)
        $name = trim($request->input('f_name') . ' ' . $request->input('l_name'));

        // Create user
        $user = User::create([
            'name' => $name,
            'first_name' => $request->input('f_name'), 
            'last_name' => $request->input('l_name'),  
            'email' => $request->input('email'),
            'country' => $request->input('country'),   
            'password' => Hash::make($request->input('password')),
        ]);

        // Auto-login the user
        Auth::login($user);

        // Prevent session fixation
        $request->session()->regenerate();
        // Return success response
        // Adjust redirect URL as needed
        $redirectUrl = route('index'); // or any other route you want to redirect to

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful! You are now logged in.',
            'redirect' => $redirectUrl,
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

    public function login(FrontendLoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $remember    = (bool) $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Prevent session fixation
            $request->session()->regenerate();
            // Redirect to intended page or default
            $redirectUrl = route('index'); 

            return response()->json([
                'status'   => 'success',
                'message'  => 'Login successful! Redirecting...',
                'redirect' => $redirectUrl,
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Invalid credentials.',
            'errors'  => [
                'email'    => ['We can’t find a user with those credentials.'],
                'password' => ['Check your password and try again.'],
            ],
        ], 422);
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
