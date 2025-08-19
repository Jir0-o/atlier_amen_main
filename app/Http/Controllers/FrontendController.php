<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Category;
use App\Models\Contract;
use App\Models\FooterSetting;
use App\Models\Work;
use COM;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Order;

class FrontendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)->where('is_vip', false)->latest()->get();
        //recently added 2 categories
        $recentWorks = Work::where('is_active', true)->where('work_type',  'art')->latest()->take(2)->get();
        $featuredWorks = Work::where('is_featured', 1)
        ->latest()
        ->take(8) 
        ->get();
        return view('frontend.home.index', compact('categories', 'recentWorks', 'featuredWorks'));
    }

    public function shop()
    {
        $Works = Work::where('is_active', true)->latest()->paginate(10);
        return view('frontend.purchase.shop', compact('Works'));
    }

    public function exhibition()
    {
        $user = auth()->user();

        $categories = Category::where('is_active', true)
            ->where('is_vip', true)
            ->latest()
            ->get();

        $hasVipAccess = false;
        if ($user) {
            $hasVipAccess = Order::where('user_id', $user->id)->exists();
        }

        $categoryId = optional($categories->first())->id;

        if ($hasVipAccess && $categoryId) {
            $vipWorks = Work::where('is_active', true)
                ->where('category_id', $categoryId)
                ->latest()
                ->paginate(12);
        } else {
            $vipWorks = new LengthAwarePaginator([], 0, 12); 
        }

        return view('frontend.works.vip_exhibition', compact('categories', 'vipWorks', 'hasVipAccess'));
    }
    public function cart()
    {
        $featuredWorks = Work::where('is_featured', 1)
        ->latest()
        ->get();
        return view('frontend.purchase.cart', compact('featuredWorks'));
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
        $about = About::first();
        return view('frontend.about-contract.about', compact('about'));
    }

    public function contact()
    {
        $contact = Contract::first();
        return view('frontend.about-contract.contact', compact('contact'));
    }

    // public function wishlist()
    // {
    //     return view('frontend.wishlist.wishlist');
    // }

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
