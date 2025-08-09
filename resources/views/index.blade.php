@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="content-wrapper pb-0">
  <!-- ====== Stat Cards ====== -->
  <div class="row g-3 mb-3">
    <div class="col-12 col-md-3">
      <div class="card stat-card h-100">
        <div class="card-body d-flex align-items-center">
          <div class="icon-wrap"><i class="mdi mdi-package-variant-closed mdi-24px"></i></div>
          <div>
            <div class="text-muted small">TOTAL PRODUCTS</div>
            <div class="h4 mb-0 head-count" id="totalProductsText">0</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card stat-card h-100">
        <div class="card-body d-flex align-items-center">
          <div class="icon-wrap"><i class="mdi mdi-cart-outline mdi-24px"></i></div>
          <div>
            <div class="text-muted small">TOTAL ORDERS</div>
            <div class="h4 mb-0 head-count" id="totalOrdersText">0</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card stat-card h-100">
        <div class="card-body d-flex align-items-center">
          <div class="icon-wrap"><i class="mdi mdi-calendar-today mdi-24px"></i></div>
          <div>
            <div class="text-muted small">TODAY'S ORDERS</div>
            <div class="h4 mb-0 head-count" id="todaysOrdersText">0</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card stat-card h-100">
        <div class="card-body d-flex align-items-center">
          <div class="icon-wrap"><i class="mdi mdi-timetable mdi-24px"></i></div>
          <div>
            <div class="text-muted small">DAILY ORDERS (AVG)</div>
            <div class="h4 mb-0 head-count" id="dailyOrdersText">0</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ====== Sales Revenue ====== -->
    <div class="row">
        <div class="col-xl-9">
            <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-wrap">
                <div>
                    <div class="card-title mb-0">Sales Revenue</div>
                    <h3 class="font-weight-bold mb-0" id="revenueTotalText">$0</h3>
                </div>
                <div>
                    <div class="d-flex flex-wrap pt-2 justify-content-between sales-header-right">
                    <div class="d-flex me-4">
                        <button type="button" class="btn btn-sm btn-outline-sales me-2">
                        <i class="mdi mdi-inbox-arrow-down"></i>
                        </button>
                        <div>
                        <h5 class="mb-0 font-weight-semibold head-count" id="totalSalesText">$0</h5>
                        <span class="small text-muted">TOTAL SALES</span>
                        </div>
                    </div>
                    <div class="d-flex mt-2 mt-sm-0">
                        <button type="button" class="btn btn-sm btn-outline-sales profit me-2">
                        <i class="mdi mdi-cash"></i>
                        </button>
                        <div>
                        <h5 class="mb-0 font-weight-semibold head-count" id="totalProfitText">0</h5>
                        <span class="small text-muted">TOTAL PROFIT</span>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <p class="text-muted small mt-2 mb-3">
                Your sales monitoring dashboard template.
                <span class="badge badge-soft ms-1">Demo</span>
                </p>

                <div class="flot-chart-wrapper">
                <canvas id="salesRevenueChart" height="120"></canvas>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<script>
const demoLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
const demoData   = [1200, 1900, 3000, 2500, 2800, 3500, 4200, 5000];

const ctx = document.getElementById('salesRevenueChart').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: demoLabels,
    datasets: [{
      label: 'Revenue ($)',
      data: demoData,
      backgroundColor: '#4e73df',
      borderRadius: 6
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
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
@endsection
