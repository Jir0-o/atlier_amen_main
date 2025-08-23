<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Can View Dashboard')->only('index');
    }
    public function index()
    {
        // --- Time window: last 12 months (including current month)
        $start = Carbon::now()->startOfMonth()->subMonths(11);
        $months = collect();
        $cursor = $start->copy();
        while ($cursor->lte(Carbon::now()->startOfMonth())) {
            $months->push($cursor->format('Y-m'));
            $cursor->addMonth();
        }

        // --- Monthly revenue & order count
        // If you have order statuses, you can add ->where('status', 'completed')
        $monthlyStats = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym')
            ->selectRaw('SUM(grand_total) as revenue')
            ->selectRaw('COUNT(*) as orders')
            ->where('created_at', '>=', $start)
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->keyBy('ym');

        $labels = [];
        $revenueData = [];
        $orderCountData = [];

        foreach ($months as $ym) {
            $labels[]        = Carbon::createFromFormat('Y-m', $ym)->format('M Y');
            $revenueData[]   = (float) ($monthlyStats[$ym]->revenue ?? 0);
            $orderCountData[] = (int)   ($monthlyStats[$ym]->orders  ?? 0);
        }

        // --- Popular purchases (by total quantity)
        $popularPurchases = OrderItem::select('work_id', DB::raw('SUM(quantity) as total_purchase'))
            ->groupBy('work_id')
            ->orderByDesc('total_purchase')
            ->with(['work' => function ($q) {
                $q->select('id', 'name', 'created_at');
            }])
            ->limit(10)
            ->get();

        // --- Top buyers (by spend)
        $topBuyers = Order::select('user_id')
            ->selectRaw('SUM(total_qty) as items')
            ->selectRaw('SUM(grand_total) as spend')
            ->groupBy('user_id')
            ->orderByDesc('spend')
            ->with(['user:id,name']) // adjust if your user columns differ
            ->limit(10)
            ->get();

        $buyerList = Order::select('user_id')
            ->selectRaw('SUM(total_qty) as items')
            ->selectRaw('SUM(grand_total) as spend')
            ->groupBy('user_id')
            ->orderByDesc('spend')
            ->with(['user:id,name']) // adjust if your user columns differ
            ->get();

        // --- (Optional) Quick KPIs you might show elsewhere
        $totalWorks     = Work::count();
        $activeWorks    = Work::where('is_active', 1)->count();
        $pendingOrders    = Order::where('status', 'pending')->count();
        $totalRevenue   = Order::sum('grand_total');

        return view('index', [
            // charts
            'chartLabels'     => $labels,
            'chartRevenue'    => $revenueData,
            'chartOrderCount' => $orderCountData,

            // tables
            'popularPurchases' => $popularPurchases,
            'topBuyers'        => $topBuyers,

            // optional KPIs
            'totalWorks'   => $totalWorks,
            'activeWorks'  => $activeWorks,
            'pendingOrders'  => $pendingOrders,
            'totalRevenue' => $totalRevenue,

            'buyerList' => $buyerList
        ]);
    }
}
