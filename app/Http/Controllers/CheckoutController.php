<?php

namespace App\Http\Controllers;

use App\Models\TempCart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Work;
use App\Models\WorkVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        $buyQty      = (int) $request->query('buy_qty', 0);

        $baseQuery = TempCart::with(['work','workVariant.attributeValues.attribute'])
            ->where(function($q) use($user, $session) {
                if ($user) $q->where('user_id', $user->id);
                else $q->whereNull('user_id')->where('session_id', $session);
            });

        $lines = $cartLineId
            ? $baseQuery->where('id', $cartLineId)->get()
            : $baseQuery->orderBy('created_at','desc')->get();

        // If buy-now view: override quantity for display/totals only
        if ($cartLineId && $lines->isNotEmpty() && $buyQty > 0) {
            $lines->first()->quantity = $buyQty;
        }

        $items          = collect(); 
        $stockoutItems  = collect(); 

        foreach ($lines as $line) {
            $work    = $line->work;
            $variant = $line->workVariant;

            // Inactive work => stockout
            if (!$work || (int)$work->is_active !== 1) {
                $line->setAttribute('stock_reason', 'inactive');
                $stockoutItems->push($line);
                continue;
            }

            // Available stock (variant first; else top-level work qty). Null => unlimited.
            $available = $variant ? $variant->stock : $work->quantity;

            if ($available === null) {
                // Unlimited → purchasable
                $line->setAttribute('available', null);
                $items->push($line);
                continue;
            }

            $available = (int) $available;
            $qty       = (int) $line->quantity;

            if ($available <= 0) {
                $line->setAttribute('available', 0);
                $line->setAttribute('stock_reason', 'out_of_stock');
                $stockoutItems->push($line);
                continue;
            }

            if ($qty > $available) {
                $line->setAttribute('available', $available);
                $line->setAttribute('stock_reason', 'insufficient');
                $stockoutItems->push($line);
                continue;
            }

            // Good to go
            $line->setAttribute('available', $available);
            $items->push($line);
        }

        // --- Totals from purchasable items only ---
        $subtotal = $items->sum(function($i){
            $unit = $i->unit_price ?? ($i->work->price ?? 0);
            return (int)$i->quantity * (float)$unit;
        });
        $totalQty       = (int) $items->sum('quantity');
        $shippingCharge = 10.00;
        $grandTotal     = $subtotal + $shippingCharge;

        // --- Prefill shipping/billing (your existing logic) ---
        $shipping = null;
        $billing  = null;
        $prefill  = [];
        $billingSameDefault = false;

        if ($user) {
            $user->load(['shippingAddress','billingAddress']);
            $shipping = $user->shippingAddress;
            $billing  = $user->billingAddress;

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

            $hasAnyAddress = (bool) ($shipping || $billing);
            $billingSameDefault = $hasAnyAddress
                && $shipping && $billing
                && (trim((string)$shipping->zip) !== '' && trim((string)$billing->zip) !== '')
                && (trim((string)$shipping->zip) === trim((string)$billing->zip));
        }
        return view('frontend.purchase.checkout', [
            'items'              => $items,      
            'stockoutItems'      => $stockoutItems,  
            'subtotal'           => $subtotal,
            'totalQty'           => $totalQty,
            'shippingCharge'     => $shippingCharge,
            'grandTotal'         => $grandTotal,
            'shipping'           => $shipping,
            'billing'            => $billing,
            'prefill'            => $prefill,
            'billingSameDefault' => $billingSameDefault,
        ]);
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

            // Buy-now / line selection
            'buy_now_id'   => 'nullable|integer|exists:works,id',
            'cart_line_id' => 'nullable|integer',
            'buy_qty'      => 'nullable|integer|min:1|max:999',
        ]);

        $user       = $request->user();
        $session    = $request->session()->getId();
        $cartLineId = $data['cart_line_id'] ?? null;
        $buyQty     = isset($data['buy_qty']) ? (int) $data['buy_qty'] : null;

        // Base cart query, restricted to current user/session AND only active works
        $baseQuery = TempCart::with(['work', 'workVariant.attributeValues.attribute'])
            ->where(function ($q) use ($user, $session) {
                if ($user) $q->where('user_id', $user->id);
                else $q->whereNull('user_id')->where('session_id', $session);
            })
            ->whereHas('work', function ($q) {
                $q->where('is_active', 1);
            });

        if ($cartLineId) {
            $baseQuery->where('id', $cartLineId);
        }

        $cartItems = $baseQuery->get();
        $cartItems = $cartItems->filter(function($line){
            $work = $line->work;
            if (!$work || (int)$work->is_active !== 1) return false;
            if ($line->work_variant_id) {
                $stock = optional($line->workVariant)->stock;
            } else {
                $stock = $work->quantity;
            }
            if (is_null($stock)) return true;          
            if ((int)$stock <= 0) return false;           
            return (int)$line->quantity <= (int)$stock;       
        });
        if ($cartItems->isEmpty()) {
            return back()->withErrors(['cart' => 'No available items to checkout.']);
        }


        try {
            DB::transaction(function () use ($cartItems, $data, $user, $cartLineId, $buyQty, $request) {
                // Helper: per-line purchased quantity (supports buy-now override)
                $computeQty = function ($item) use ($cartLineId, $buyQty) {
                    if ($cartLineId && $item->id == $cartLineId && $buyQty) {
                        return max(1, min($buyQty, (int) $item->quantity));
                    }
                    return (int) $item->quantity;
                };

                // LOCK & VALIDATE STOCK and compute totals
                $subtotal = 0.0;
                $totalQty = 0;

                // Keep the locked rows to apply decrements AFTER order creation
                $locks = []; // array of ['type'=>'variant'|'work','model'=>$model,'qty'=>int]

                foreach ($cartItems as $it) {
                    $purchaseQty = $computeQty($it);
                    if ($purchaseQty <= 0) {
                        throw ValidationException::withMessages([
                            'cart' => ['Invalid quantity selected.'],
                        ]);
                    }

                    $unitPrice = $it->unit_price ?? ($it->work->price ?? 0);
                    $subtotal += $unitPrice * $purchaseQty;
                    $totalQty += $purchaseQty;

                    if ($it->work_variant_id) {
                        // Lock the variant and ensure its parent work is active
                        $variant = WorkVariant::query()
                            ->whereKey($it->work_variant_id)
                            ->whereHas('work', fn($q) => $q->where('is_active', 1))
                            ->lockForUpdate()
                            ->first();

                        if (!$variant) {
                            throw ValidationException::withMessages([
                                'cart' => ['One of the selected variants is unavailable.'],
                            ]);
                        }

                        if (!is_null($variant->stock) && $variant->stock < $purchaseQty) {
                            throw ValidationException::withMessages([
                                'cart' => ["Insufficient stock for '{$it->variant_text}'."],
                            ]);
                        }

                        $locks[] = ['type' => 'variant', 'model' => $variant, 'qty' => $purchaseQty];
                    } else {
                        // No variant: lock the Work (if you track top-level qty)
                        $work = Work::query()
                            ->whereKey($it->work_id)
                            ->where('is_active', 1)
                            ->lockForUpdate()
                            ->first();

                        if (!$work) {
                            throw ValidationException::withMessages([
                                'cart' => ['One of the selected items is unavailable.'],
                            ]);
                        }

                        if (!is_null($work->quantity) && $work->quantity < $purchaseQty) {
                            throw ValidationException::withMessages([
                                'cart' => ["Insufficient stock for '{$work->name}'."],
                            ]);
                        }

                        $locks[] = ['type' => 'work', 'model' => $work, 'qty' => $purchaseQty];
                    }
                }

                $shippingCharge = 10.00; // flat example
                $grandTotal     = $subtotal + $shippingCharge;

                $sameBilling = (bool) ($request->boolean('billing_form', true));

                // CREATE ORDER
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

                // CREATE ORDER ITEMS
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

                // APPLY STOCK DECREMENTS (on the locked rows)
                foreach ($locks as $lock) {
                    if ($lock['type'] === 'variant') {
                        /** @var WorkVariant $v */
                        $v = $lock['model'];
                        if (!is_null($v->stock)) {
                            $v->decrement('stock', $lock['qty']);
                        }
                    } else {
                        /** @var Work $w */
                        $w = $lock['model'];
                        if (!is_null($w->quantity)) {
                            $w->decrement('quantity', $lock['qty']);
                        }
                    }
                }

                foreach ($cartItems as $item) {
                    $purchaseQty = $computeQty($item);
                    if ($purchaseQty >= $item->quantity) {
                        $item->delete();
                    } else {
                        $item->decrement('quantity', $purchaseQty);
                    }
                }
            });


            return redirect()
                ->route('index')
                ->with('success', 'Your order has been placed successfully!');
        } catch (ValidationException $ve) {
            return back()->withErrors($ve->errors())->withInput();
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors(['checkout' => 'Checkout failed. Please try again.'])->withInput();
        }
    }
}