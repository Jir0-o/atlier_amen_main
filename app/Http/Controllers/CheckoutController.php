<?php

namespace App\Http\Controllers;

use App\Models\TempCart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Work;
use App\Models\WorkVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display the checkout form.
     */
// app/Http/Controllers/CheckoutController.php

    public function show(Request $request)
    {
        $user        = auth()->user();
        $session     = $request->session()->getId();
        $cartLineId  = $request->query('cart_line_id');
        $buyQty      = (int) $request->query('buy_qty', 0); // 0 = no override

        $baseQuery = TempCart::with(['work','workVariant.attributeValues.attribute'])
            ->where(function($q) use($user, $session) {
                if ($user) $q->where('user_id', $user->id);
                else $q->whereNull('user_id')->where('session_id', $session);
            });

        $items = $cartLineId
            ? $baseQuery->where('id', $cartLineId)->get()
            : $baseQuery->orderBy('created_at','desc')->get();

        // If buy-now view: override the line’s quantity for the totals/display only
        if ($cartLineId && $items->isNotEmpty() && $buyQty > 0) {
            $items->first()->quantity = $buyQty;
        }

        $subtotal       = $items->sum(fn($i) => $i->quantity * ($i->unit_price ?? 0));
        $totalQty       = $items->sum('quantity');
        $shippingCharge = 10.00;
        $grandTotal     = $subtotal + $shippingCharge;

        $shipping = null;
        $billing  = null;
        $prefill  = [];
        $billingSameDefault = false;

        if ($user) {
            $user->load(['shippingAddress','billingAddress']);
            $shipping = $user->shippingAddress;
            $billing  = $user->billingAddress;

            // Prefill ONLY Shipping fields from DB (names from users, address from shippingAddress)
            if ($shipping) {
                $prefill = [
                    'f_name'  => $user->first_name ?? '',
                    'l_name'  => $user->last_name ?? '',
                    'address' => $shipping->street ?? '',
                    'city'    => $shipping->city ?? '',
                    'state'   => $shipping->state ?? '',
                    'zip'     => $shipping->zip ?? '',
                    'country' => $shipping->country ?? '',
                ];
            }

            // Checkbox default: tick only if there is address data AND zip matches
            $hasAnyAddress = (bool) ($shipping || $billing);
            $billingSameDefault = $hasAnyAddress
                && $shipping && $billing
                && (trim((string)$shipping->zip) !== '' && trim((string)$billing->zip) !== '')
                && (trim((string)$shipping->zip) === trim((string)$billing->zip));
        }

        return view('frontend.purchase.checkout', compact(
            'items','subtotal','totalQty','shippingCharge','grandTotal',
            'shipping','billing','prefill','billingSameDefault'
        ));
    }




    // public function buyNow(Request $request)
    // {
    //     $validated = $request->validate([
    //         'work_id'    => 'required|exists:works,id',
    //         'variant_id' => 'required|exists:work_variants,id',
    //         'qty'        => 'nullable|integer|min:1|max:50',
    //     ]);

    //     $qty       = $validated['qty'] ?? 1;
    //     $work      = Work::findOrFail($validated['work_id']);
    //     $variant   = WorkVariant::where('id',$validated['variant_id'])
    //                     ->where('work_id',$work->id)->firstOrFail();

    //     // stock check
    //     if ($variant->stock !== null && $qty > $variant->stock) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Not enough stock for this option.'
    //         ], 422);
    //     }

    //     // Persist a "buy now" session payload (consumed by checkout form)
    //     session(['buy_now' => [
    //         'work_id'        => $work->id,
    //         'variant_id'     => $variant->id,
    //         'qty'            => $qty,
    //         'name'           => $work->name,
    //         'unit_price'     => $variant->price ?? $work->price,
    //         'image'          => $work->work_image_low ?? $work->work_image_low_url,
    //         'sku'            => $variant->sku,
    //     ]]);

    //     // Redirect to checkout form
    //     return response()->json([
    //         'status'   => 'success',
    //         'redirect' => route('checkout.form', ['mode' => 'buy-now']),
    //     ]);
    // }


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
            'cart_line_id' => 'nullable|integer',
            'buy_qty'      => 'nullable|integer|min:1|max:999',
        ]);

        $user        = $request->user();
        $session     = $request->session()->getId();
        $cartLineId  = $data['cart_line_id'] ?? null;
        $buyQty      = isset($data['buy_qty']) ? (int)$data['buy_qty'] : null;

        $baseQuery = TempCart::with(['work','workVariant.attributeValues.attribute'])
            ->where(function($q) use ($user, $session) {
                if ($user) $q->where('user_id', $user->id);
                else $q->whereNull('user_id')->where('session_id', $session);
            });

        if ($cartLineId) {
            $baseQuery->where('id', $cartLineId);
        }

        $cartItems = $baseQuery->get();
        if ($cartItems->isEmpty()) {
            return back()->withErrors(['cart' => 'No items selected for checkout.']);
        }

        DB::transaction(function() use ($cartItems, $data, $user, $cartLineId, $buyQty) {
            // Build totals using either the cart qty or the buy-now override
            $computeQty = function($item) use ($cartLineId, $buyQty) {
                if ($cartLineId && $item->id == $cartLineId && $buyQty) {
                    // Purchase only the requested amount (capped at available cart qty)
                    return max(1, min($buyQty, (int)$item->quantity));
                }
                return (int)$item->quantity;
            };

            $subtotal = 0;
            $totalQty = 0;
            foreach ($cartItems as $it) {
                $q = $computeQty($it);
                $subtotal += $q * ($it->unit_price ?? 0);
                $totalQty += $q;
            }
            $shippingCharge = 10.00;
            $grandTotal     = $subtotal + $shippingCharge;

            $sameBilling = request()->boolean('billing_form', true);

            $order = Order::create([
                'user_id'         => $user?->id,
                'total_qty'       => $totalQty,
                'subtotal'        => $subtotal,
                'shipping_charge' => $shippingCharge,
                'grand_total'     => $grandTotal,
                // shipping...
                'ship_fname'   => $data['f_name'],
                'ship_lname'   => $data['l_name'],
                'ship_address' => $data['address'],
                'ship_city'    => $data['city'],
                'ship_state'   => $data['state'] ?? '',
                'ship_zip'     => $data['zip'] ?? '',
                'ship_country' => $data['country'],
                // billing...
                'bill_fname'   => $sameBilling ? $data['f_name'] : ($data['bill_f_name'] ?? ''),
                'bill_lname'   => $sameBilling ? $data['l_name'] : ($data['bill_l_name'] ?? ''),
                'bill_address' => $sameBilling ? $data['address'] : ($data['bill_address'] ?? ''),
                'bill_city'    => $sameBilling ? $data['city'] : ($data['bill_city'] ?? ''),
                'bill_state'   => $sameBilling ? ($data['state'] ?? '') : ($data['bill_state'] ?? ''),
                'bill_zip'     => $sameBilling ? ($data['zip'] ?? '') : ($data['bill_zip'] ?? ''),
                'bill_country' => $sameBilling ? $data['country'] : ($data['bill_country'] ?? ''),
            ]);

            // Create order items using the computed qty
            foreach ($cartItems as $item) {
                $purchaseQty = $computeQty($item);
                $unitPrice   = $item->unit_price ?? ($item->work->price ?? 0);
                $lineTotal   = $unitPrice * $purchaseQty;

                OrderItem::create([
                    'order_id'        => $order->id,
                    'work_id'         => $item->work_id,
                    'work_variant_id' => $item->work_variant_id,
                    'variant_text'    => $item->variant_text,
                    'quantity'        => $purchaseQty,
                    'unit_price'      => $unitPrice,
                    'line_total'      => $lineTotal,
                ]);
            }

            // Adjust ONLY the processed lines:
            foreach ($cartItems as $item) {
                $purchaseQty = $computeQty($item);

                if ($purchaseQty >= $item->quantity) {
                    // bought them all -> delete the row
                    $item->delete();
                } else {
                    // partial buy -> decrement remaining qty in cart
                    $item->decrement('quantity', $purchaseQty);
                }
            }
        });

        return redirect()
            ->route('index')
            ->with('success', 'Your order has been placed successfully!');
    }

}