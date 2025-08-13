@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="content-wrapper pb-0">
        <h2>Welcome in Atlier Amen</h2>
        <div class="d-flex gap-4 flex-wrap justify-content-between mb-4">
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
                        <i class="mdi mdi-brush"></i> 53 total art
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3">Sales Chart</h4>
                        <canvas id="salesRevenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

    <script>
        Chart.defaults.color = '#FFFFFF';
        const demoLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
        const demoData = [1200, 1900, 3000, 2500, 2100, 3500, 4200, 1500];

        const ctx = document.getElementById('salesRevenueChart').getContext('2d');
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
