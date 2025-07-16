<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.home.index');
    }

    public function shop()
    {
        return view('frontend.purchase.shop');
    }

    public function exhibition()
    {
        return view('frontend.art-info.exhibition');
    }

    public function cart()
    {
        return view('frontend.purchase.cart');
    }

    public function login()
    {
        return view('frontend.auth.login');
    }

    public function register()
    {
        return view('frontend.auth.registration');
    }

    public function resetPassword()
    {
        return view('frontend.auth.forgot');
    }

    public function about()
    {
        return view('frontend.about-contract.about');
    }

    public function contact()
    {
        return view('frontend.about-contract.contact');
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
    public function store(Request $request)
    {
        //
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
}
