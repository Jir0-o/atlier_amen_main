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
        $orders = Order::with(['user', 'items.work']);

        return DataTables::of($orders)
            ->addColumn('user', fn($order) => $order->user->name ?? 'Guest')
            ->addColumn('products', function($order) {
                return $order->items->map(fn($i) => $i->work->name . ' (x' . $i->quantity . ')')->implode('<br>');
            })
            ->addColumn('status', function($order) {
                return '<span class="badge bg-' .
                    ($order->status === 'pending' ? 'warning' : ($order->status === 'accepted' ? 'success' : 'danger')) .
                    '">' . ucfirst($order->status) . '</span>';
            })
            ->addColumn('action', function ($order) {
                if ($order->status !== 'pending') {
                    return '<button class="btn btn-sm btn-primary view-order" data-id="' . $order->id . '">View</button>';
                }

                return '
                    <button class="btn btn-sm btn-primary view-order" data-id="' . $order->id . '">View</button>
                    <button class="btn btn-sm btn-success accept-order" data-id="' . $order->id . '">Accept</button>
                    <button class="btn btn-sm btn-danger reject-order" data-id="' . $order->id . '">Reject</button>';
            })
            ->filterColumn('products', function ($query, $keyword) {
                $query->whereHas('items.work', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['products', 'status', 'action'])
            ->make(true);
    }


    public function show(Order $order)
    {
        $order->load(['items.work', 'user']);

        $items = $order->items->map(function ($item) {
            return [
                'product'     => $item->work->name ?? 'Deleted',
                'quantity'    => $item->quantity,
                'unit_price'  => number_format($item->unit_price, 2),
                'line_total'  => number_format($item->line_total, 2),
            ];
        });

        return response()->json([
            'id'         => $order->id,
            'user'       => $order->user->name ?? 'Guest',
            'total_qty'  => $order->total_qty,
            'subtotal'   => number_format($order->subtotal, 2),
            'shipping'   => number_format($order->shipping_charge, 2),
            'grand_total'=> number_format($order->grand_total, 2),
            'items'      => $items,
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
