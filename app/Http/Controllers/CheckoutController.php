<?php

namespace App\Http\Controllers;

use App\Models\TempCart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display the checkout form.
     */
    public function show(Request $request)
    {
        $user    = auth()->user();
        $session = $request->session()->getId();

        $buyNowId = $request->query('buy_now_id');

        $baseQuery = TempCart::with('work')
            ->where(function($q) use($user, $session) {
                if ($user) {
                    $q->where('user_id', $user->id);
                } else {
                    $q->whereNull('user_id')
                    ->where('session_id', $session);
                }
            });

        if ($buyNowId) {
            $items = $baseQuery->where('work_id', $buyNowId)->get();
        } else {
            $items = $baseQuery->orderBy('created_at','desc')->get();
        }

        $subtotal       = $items->sum(fn($i) => $i->quantity * ($i->work->price ?? 0));
        $totalQty       = $items->sum('quantity');
        $shippingCharge = 10.00;
        $grandTotal     = $subtotal + $shippingCharge;

        return view('frontend.purchase.checkout', compact(
        'items','subtotal','totalQty','shippingCharge','grandTotal'
        ));
    }


    /**
     * Process the order: move cart → orders + order_items, then clear cart.
     */
    public function process(Request $request)
    {
        $data = $request->validate([
            // Shipping
            'f_name'       => 'required|string|max:255',
            'l_name'       => 'required|string|max:255',
            'address'      => 'required|string',
            'city'         => 'required|string|max:100',
            'state'        => 'nullable|string|max:100',
            'zip'          => 'nullable|string|max:20',
            'country'      => 'required|string|max:100',

            // Billing same-as-shipping
            'billing_form' => 'sometimes|accepted',
            'bill_f_name'  => 'nullable|required_without:billing_form|string|max:255',
            'bill_l_name'  => 'nullable|required_without:billing_form|string|max:255',
            'bill_address' => 'nullable|required_without:billing_form|string',
            'bill_city'    => 'nullable|required_without:billing_form|string|max:100',
            'bill_state'   => 'nullable|string|max:100',
            'bill_zip'     => 'nullable|string|max:20',
            'bill_country' => 'nullable|required_without:billing_form|string|max:100',
            'buy_now_id'   => 'nullable|integer|exists:works,id',
        ]);

        $user        = $request->user();
        $session     = $request->session()->getId();
        $sameBilling = $request->has('billing_form');
        $buyNowId    = $data['buy_now_id'] ?? null;

        // Build base query for this user/session
        $baseQuery = TempCart::with('work')
            ->where(function($q) use ($user, $session) {
                if ($user) {
                    $q->where('user_id', $user->id);
                } else {
                    $q->whereNull('user_id')
                      ->where('session_id', $session);
                }
            });

        // If buy_now_id is set, narrow to just that one line
        if ($buyNowId) {
            $baseQuery->where('work_id', $buyNowId);
        }

        $cartItems = $baseQuery->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors(['cart' => 'No items selected for checkout.']);
        }

        DB::transaction(function() use ($cartItems, $data, $user, $sameBilling) {
            // Totals
            $subtotal       = $cartItems->sum(fn($i) => $i->quantity * ($i->work->price ?? 0));
            $totalQty       = $cartItems->sum('quantity');
            $shippingCharge = 10.00;
            $grandTotal     = $subtotal + $shippingCharge;

            // Create order
            $order = Order::create([
                'user_id'         => $user->id,
                'total_qty'       => $totalQty,
                'subtotal'        => $subtotal,
                'shipping_charge' => $shippingCharge,
                'grand_total'     => $grandTotal,

                // Shipping fields
                'ship_fname'      => $data['f_name'],
                'ship_lname'      => $data['l_name'],
                'ship_address'    => $data['address'],
                'ship_city'       => $data['city'],
                'ship_state'      => $data['state']   ?? '',
                'ship_zip'        => $data['zip']     ?? '',
                'ship_country'    => $data['country'],

                // Billing (use shipping if same-as-shipping checked)
                'bill_fname'      => $sameBilling
                                      ? $data['f_name']
                                      : $data['bill_f_name'],
                'bill_lname'      => $sameBilling
                                      ? $data['l_name']
                                      : $data['bill_l_name'],
                'bill_address'    => $sameBilling
                                      ? $data['address']
                                      : $data['bill_address'],
                'bill_city'       => $sameBilling
                                      ? $data['city']
                                      : $data['bill_city'],
                'bill_state'      => $sameBilling
                                      ? ($data['state'] ?? '')
                                      : ($data['bill_state'] ?? ''),
                'bill_zip'        => $sameBilling
                                      ? ($data['zip'] ?? '')
                                      : ($data['bill_zip'] ?? ''),
                'bill_country'    => $sameBilling
                                      ? $data['country']
                                      : $data['bill_country'],
            ]);

            // Create order items for each selected cart line
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'work_id'    => $item->work_id,
                    'quantity'   => $item->quantity,
                    'unit_price' => $item->work->price ?? 0,
                    'line_total' => $item->quantity * ($item->work->price ?? 0),
                ]);
            }

            // Delete only the cart lines we just processed
            $ids = $cartItems->pluck('id')->all();
            TempCart::whereIn('id', $ids)->delete();
        });

        return redirect()
            ->route('checkout.form')
            ->with('success', 'Your order has been placed successfully!');
    }

}
