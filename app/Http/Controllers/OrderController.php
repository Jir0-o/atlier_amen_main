<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        return view('backend.orders.index'); 
    }

    public function data(Request $request)
    {
        // Eager-load for speed
        $q = Order::with(['user:id,first_name,last_name,email', 'items.work'])
            ->latest();

        return DataTables::of($q)
            ->addColumn('user', function (Order $o) {
                $n = trim(($o->user->first_name ?? '').' '.($o->user->last_name ?? ''));
                $n = $n !== '' ? $n : ($o->user->email ?? 'N/A');
                return e($n);
            })
            ->addColumn('products', function (Order $o) {
                return e(
                    $o->items->map(fn($it) =>
                        ($it->work->name ?? 'Item').' ×'.$it->quantity
                    )->join(', ')
                );
            })
            ->addColumn('grand_total', fn(Order $o) => number_format((float)$o->grand_total, 2))
            ->addColumn('total_qty', fn(Order $o) => (int)$o->total_qty)
            ->addColumn('status', function (Order $o) {
                $map = [
                    'pending'   => 'warning',
                    'accepted'  => 'primary',
                    'completed' => 'success',
                    'rejected'  => 'danger',
                    'cancelled' => 'secondary',
                ];
                $cls = $map[$o->status] ?? 'secondary';
                return '<span class="badge bg-'.$cls.'">'.e(ucfirst($o->status)).'</span>';
            })
            ->addColumn('order_datetime', function (Order $o) {
                // Show date & time
                return $o->created_at?->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function (Order $o) {
                $id = $o->id;
                $viewBtn   = '<button class="btn btn-sm btn-info view-order" data-id="'.$id.'">View</button>';
                $acceptBtn = $o->status === 'pending'
                    ? '<button class="btn btn-sm btn-success ms-1 accept-order" data-id="'.$id.'">Accept</button>'
                    : '';
                $rejectBtn = $o->status === 'pending'
                    ? '<button class="btn btn-sm btn-danger ms-1 reject-order" data-id="'.$id.'">Reject</button>'
                    : '';
                return $viewBtn.$acceptBtn.$rejectBtn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
    }


    public function show(Order $order)
    {
        $order->load([
            'user:id,first_name,last_name,email,phone',
            'items.work',
            'items.workVariant'
        ]);

        // Line items (with image + variant)
        $items = $order->items->map(function ($it) {
            $w       = $it->work;
            $variant = $it->variant_text ?: ($it->workVariant->name ?? null);
            $img     = $w?->work_image_low ?? $w?->work_image;

            return [
                'product'     => $w?->name ?? 'Item',
                'work_id'     => $w?->id,
                'variant'     => $variant,
                'quantity'    => (int) $it->quantity,
                'unit_price'  => number_format((float) $it->unit_price, 2),
                'line_total'  => number_format((float) $it->line_total, 2),
                'image'       => $img ? asset($img) : asset('images/no-image.png'),
            ];
        })->values();

        // Build shipping & billing blocks inline (no model helpers)
        $shipping = [
            'name'    => trim(($order->ship_fname ?? '') . ' ' . ($order->ship_lname ?? '')) ?: null,
            'address' => $order->ship_address,
            'city'    => $order->ship_city,
            'state'   => $order->ship_state,
            'zip'     => $order->ship_zip,
            'country' => $order->ship_country,
        ];

        $billing = [
            'name'    => trim(($order->bill_fname ?? '') . ' ' . ($order->bill_lname ?? '')) ?: null,
            'address' => $order->bill_address,
            'city'    => $order->bill_city,
            'state'   => $order->bill_state,
            'zip'     => $order->bill_zip,
            'country' => $order->bill_country,
        ];

        // Customer display name inline (fallback to email/N/A)
        $customerName = trim(($order->user->first_name ?? '') . ' ' . ($order->user->last_name ?? ''));
        if ($customerName === '') {
            $customerName = $order->user->email ?? 'N/A';
        }

        return response()->json([
            'id'           => $order->id,
            'status'       => $order->status,
            'created_at'   => $order->created_at?->format('Y-m-d H:i:s'),
            'updated_at'   => $order->updated_at?->format('Y-m-d H:i:s'),

            'total_qty'    => (int) $order->total_qty,
            'subtotal'     => number_format((float) $order->subtotal, 2),
            'shipping_charge'     => number_format((float) $order->shipping_charge, 2),
            'grand_total'  => number_format((float) $order->grand_total, 2),

            'customer' => [
                'name'  => $customerName,
                'email' => $order->user->email ?? null,
                'phone' => $order->user->phone ?? null,
                'id'    => $order->user->id ?? null,
            ],

            'shipping' => $shipping,
            'billing'  => $billing,
            'items'    => $items,
        ]);
    }


    public function accept(Order $order)
    {
        $order->update(['status' => 'accepted']);
        return back()->with('success', 'Order accepted.');
    }

    public function reject(Order $order)
    {
        $order->update(['status' => 'rejected']);
        return back()->with('success', 'Order rejected.');
    }
}
