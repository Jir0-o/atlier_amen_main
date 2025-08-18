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
            color: #191919;
            -webkit-text-stroke: 
        }
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
                        <span class="display-3">53</span> total art
                    </p>
                    <p>
                        <span class="bg-shadow">
                            <i class="mdi mdi-brush"></i>
                        </span>
                        <span class="display-3">12</span> pending order
                    </p>
                    <p>
                        <span class="bg-shadow">
                            <i class="mdi mdi-brush"></i>
                        </span>
                        <span class="display-3">$ 37,039</span> total income
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 p-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="mb-3">Sales Chart</h4>
                        <canvas id="salesRevenueChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 p-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h4 class="mb-3">Order Chart</h4>
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
                            <tr>
                                <td>01</td>
                                <td>
                                    <a class="text-dark font-weight-bold" style="text-decoration: underline;" href="./art_info.html">
                                        Lorem ipsum dolor sit amer connecter, adipisicing elis.
                                    </a>
                                </td>
                                <td>
                                    13
                                </td>
                                <td>
                                    August 14, 2025
                                </td>
                            </tr>
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
                            <tr>
                                <td>01</td>
                                <td>Atlier Amen</td>
                                <td>25</td>
                                <td>$ 4,958</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <script>
        Chart.defaults.color = '#FFFFFF';

        const demoLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
        const demoData = [1200, 1900, 3000, 2500, 2100, 3500, 4200, 1500];

        const orderLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
        const orderData = [10, 10, 30, 25, 21, 35, 42, 15];

        const ctx = document.getElementById('salesRevenueChart').getContext('2d');
        const orderChart = document.getElementById('orderChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: demoLabels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: demoData,
                    backgroundColor: '#fff',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => '$' + ctx.parsed.y.toLocaleString()
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => '$' + value.toLocaleString()
                        }
                    }
                }
            }
        });

        new Chart(orderChart, {
            type: 'pie',
            data: {
                labels: orderLabels,
                datasets: [{
                    data: orderData,
                }]
            },
            options: {
                responsive: true
            }
        })
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
