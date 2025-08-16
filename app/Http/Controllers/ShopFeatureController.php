<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Support\Feature;

class ShopFeatureController extends Controller
{
    public function edit()
    {
        $settings = Setting::whereIn('key', [
            'shop_enabled','cart_enabled','buy_now_enabled','wishlist_enabled',
        ])->pluck('value','key');

        return view('backend.settings.shop_setting', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'shop_enabled'     => ['nullable'],
            'cart_enabled'     => ['nullable'],
            'buy_now_enabled'  => ['nullable'],
            'wishlist_enabled' => ['nullable'],
        ]);

        $keys = ['shop_enabled','cart_enabled','buy_now_enabled','wishlist_enabled'];
        foreach ($keys as $k) {
            Setting::updateOrCreate(
                ['key' => $k],
                // checkbox returns "on" when checked; treat as 1/0 strings
                ['value' => $request->boolean($k) ? '1' : '0']
            );
        }

        Feature::clear();

        return back()->with('success', 'Shop features updated.');
    }
}