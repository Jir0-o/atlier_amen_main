<?php

namespace App\Http\Controllers;
use App\Models\Address;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function upsertShipping(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'street'  => ['nullable','string','max:255'],
            'city'    => ['nullable','string','max:255'],
            'state'   => ['nullable','string','max:255'],
            'zip'     => ['nullable','string','max:50'],
            'country' => ['nullable','string','max:100'],
        ]);

        Address::updateOrCreate(
            ['user_id' => $user->id, 'type' => 'shipping'],
            $data + ['is_default' => true]
        );

        return back()->with('success', 'Shipping address saved.');
        // If you prefer AJAX: return response()->json(['status'=>'success']);
    }

    public function upsertBilling(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'street'  => ['nullable','string','max:255'],
            'city'    => ['nullable','string','max:255'],
            'state'   => ['nullable','string','max:255'],
            'zip'     => ['nullable','string','max:50'],
            'country' => ['nullable','string','max:100'],
        ]);

        Address::updateOrCreate(
            ['user_id' => $user->id, 'type' => 'billing'],
            $data + ['is_default' => true]
        );

        return back()->with('success', 'Billing address saved.');
    }
}
