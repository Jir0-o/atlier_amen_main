@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        .bg-shadow {
            padding: 4px;
            border-radius: 8px;
            background-color: #f5f5f550;
            margin-inline-end: 8px;
        }

        .quick-data p {
            padding: 8px;
            border-radius: 8px;
            background-image: linear-gradient(225deg,
                    rgb(255 255 255 / 45%),
                    rgb(0 0 0 / 25%),
                    rgb(255 255 255 / 35%),
                    rgb(255 255 255 / 10%),
                    rgb(0 0 0 / 15%),
                    rgb(255 255 255 / 35%));
            backdrop-filter: blur(1px);
            color: #fff;
            /* -webkit-text-stroke: 1px solid #fff; */
        }

        .chart-wrap { position: relative; height: 400px; width: 700px; }
    </style>

    <div class="content-wrapper pb-0">
        <h2>Welcome in Atlier Amen</h2>
        <div class="d-flex gap-4 flex-wrap justify-content-between align-items-center mb-4">
            <div class="live-clock">
                <div class="d-flex align-items-end">
                    <div class="display-3" id="main_clock"></div>
                    <div id="second_clock"></div>
                    <div class="display-3 ml-2" id="meridiem_clock"></div>
                </div>
                <div class="font-weight-bold text-primary" id="date_clock" style="font-size: 12px;"></div>
            </div>
            <div class="quick-data">
                <div class="d-flex align-items-end" style="gap: 12px">
                    <p>
                        <span class="bg-shadow">
                            <i class="mdi mdi-brush"></i>
                        </span>
                        <span class="display-3">{{ $totalWorks }}</span> total art
                    </p>
                    <p>
                        <span class="bg-shadow">
                            <i class="mdi mdi-brush"></i>
                        </span>
                        <span class="display-3">{{ $pendingOrders }}</span> pending order
                    </p>
                    <p>
                        <span class="bg-shadow">
                            <i class="mdi mdi-brush"></i>
                        </span>
                        <span class="display-3">$ {{ $totalRevenue }}</span> total income
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card h-100">
            <div class="card-body">
                <h4 class="mb-3">Sales Chart</h4>
                <div class="chart-wrap">
                <canvas id="salesRevenueChart"></canvas>
                </div>
            </div>
            </div>

            <div class="card h-100">
            <div class="card-body">
                <h4 class="mb-3">Order Chart</h4>
                <div class="chart-wrap">
                <canvas id="orderChart"></canvas>
                </div>
            </div>
            </div>
            <div class="col-md-12 p-3">
                <h4>Popular Purchase</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>#SL</td>
                                <td>Product Name</td>
                                <td>Total Purchase</td>
                                <td>Upload On</td>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($popularPurchases as $i => $row)
                            <tr>
                                <td>{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td>
                                    @if($row->work)
                                        <a class="text-dark fw-bold text-decoration-underline">
                                            {{ $row->work->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">[Deleted work]</span>
                                    @endif
                                </td>
                                <td>{{ (int)$row->total_purchase }}</td>
                                <td>
                                    @if($row->work)
                                        {{ optional($row->work->created_at)->format('F d, Y') }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No data</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12 p-3">
                <h4>Top buyer</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#SL</th>
                                <th>Name</th>
                                <th>Item Buy</th>
                                <th>Total spend</th>
                            </tr>
                        </thead>
                        <tbody> 
                        @forelse($topBuyers as $i => $row)
                            <tr>
                                <td>{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ optional($row->user)->name ?? 'Unknown User' }}</td>
                                <td>{{ (int)$row->items }}</td>
                                <td>$ {{ number_format((float)$row->spend, 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No data</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <script>
        // Use controller-provided data
        const labelsFromServer  = @json($chartLabels);      // e.g., ["Sep 2024", ... "Aug 2025"]
        const revenueFromServer = @json($chartRevenue);     // numbers
        const ordersFromServer  = @json($chartOrderCount);  // numbers

        // Fallbacks (optional)
        const demoLabels = labelsFromServer?.length ? labelsFromServer : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug'];
        const demoData   = revenueFromServer?.length ? revenueFromServer : [1200,1900,3000,2500,2100,3500,4200,1500];
        const orderLabels= labelsFromServer?.length ? labelsFromServer : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug'];
        const orderData  = ordersFromServer?.length ? ordersFromServer : [10,10,30,25,21,35,42,15];

        // Global defaults (kept from your code)
        Chart.defaults.color = '#FFFFFF';

        const salesCtx = document.getElementById('salesRevenueChart');
        const orderCtx = document.getElementById('orderChart');

        if (salesCtx) {
            new Chart(salesCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: demoLabels,
                    datasets: [{
                        label: 'Revenue',
                        data: demoData,
                        borderWidth: 2,
                        tension: 0.3,
                        pointRadius: 3,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => '৳ ' + Number(ctx.parsed.y ?? 0).toLocaleString()
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: (value) => '৳ ' + Number(value ?? 0).toLocaleString()
                            }
                        }
                    }
                }
            });
        }

        if (orderCtx) {
            // Kept your "pie" type; it will show order share by month
            new Chart(orderCtx.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: orderLabels,
                    datasets: [{
                        data: orderData
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => {
                                    const label = ctx.label || '';
                                    const val = Number(ctx.parsed ?? 0);
                                    return `${label}: ${val.toLocaleString()} orders`;
                                }
                            }
                        }
                    }
                }
            });
        }
    </script>


    <script>
        function updateClock() {
            const now = new Date();

            // Get individual components
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const formattedHours = (hours % 12 || 12).toString().padStart(2, '0');
            const formattedMinutes = minutes.toString().padStart(2, '0');
            const formattedSeconds = seconds.toString().padStart(2, '0');

            // Update time elements
            document.getElementById('main_clock').textContent = `${formattedHours}:${formattedMinutes}`;
            document.getElementById('second_clock').textContent = formattedSeconds;
            document.getElementById('meridiem_clock').textContent = ampm;

            // Update date
            const dateOptions = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            document.getElementById('date_clock').textContent = now.toLocaleDateString('en-US', dateOptions);
        }

        setInterval(updateClock, 1000);
    </script>
@endsection
