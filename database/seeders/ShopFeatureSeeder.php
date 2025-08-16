<?php

namespace Database\Seeders;
use App\Models\Setting;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShopFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'shop_enabled'     => '1',
            'cart_enabled'     => '1',
            'buy_now_enabled'  => '1',
            'wishlist_enabled' => '1',
        ];
        foreach ($defaults as $k => $v) {
            Setting::updateOrCreate(['key' => $k], ['value' => $v]);
        }
    }
}
