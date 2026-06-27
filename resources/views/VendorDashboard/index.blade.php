
@extends('VendorDashboard.master')
@section('title', 'Vendor Dashboard')

@section('content')


<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Dashboard</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
        <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
            <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
            Dashboard
        </a>
        </li>
    </ul>
    </div>


<div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4">

<!-- Total Products -->
<div class="col">
<div class="card shadow-none border bg-gradient-start-1 h-100">
<div class="card-body p-20 d-flex justify-content-between align-items-center">
<div>
<p class="fw-medium text-primary-light mb-1">Total Products</p>
<h6 class="mb-0">{{ number_format($totalProducts ?? 0) }}</h6>
</div>
<div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
<iconify-icon icon="mdi:package-variant" class="text-white text-2xl"></iconify-icon>
</div>
</div>
</div>
</div>

<!-- Total Categories -->
<div class="col">
<div class="card shadow-none border bg-gradient-start-2 h-100">
<div class="card-body p-20 d-flex justify-content-between align-items-center">
<div>
<p class="fw-medium text-primary-light mb-1">Total Categories</p>
<h6 class="mb-0">{{ number_format($totalCategories ?? 0) }}</h6>
</div>
<div class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
<iconify-icon icon="mdi:shape-outline" class="text-white text-2xl"></iconify-icon>
</div>
</div>
</div>
</div>



<!-- Total Orders -->
<div class="col">
<div class="card shadow-none border bg-gradient-start-4 h-100">
<div class="card-body p-20 d-flex justify-content-between align-items-center">
<div>
<p class="fw-medium text-primary-light mb-1">Total Orders</p>
<h6 class="mb-0">{{ number_format($totalOrders ?? 0) }}</h6>
</div>
<div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
<iconify-icon icon="mdi:cart" class="text-white text-2xl"></iconify-icon>
</div>
</div>
</div>
</div>

<!-- Today's Orders -->
<div class="col">
<div class="card shadow-none border bg-gradient-start-5 h-100">
<div class="card-body p-20 d-flex justify-content-between align-items-center">
<div>
<p class="fw-medium text-primary-light mb-1">Today's Orders</p>
<h6 class="mb-0">{{ number_format($todayOrders ?? 0) }}</h6>
</div>
<div class="w-50-px h-50-px bg-warning rounded-circle d-flex justify-content-center align-items-center">
<iconify-icon icon="mdi:clock-outline" class="text-white text-2xl"></iconify-icon>
</div>
</div>
</div>
</div>

<!-- Total Income -->
<div class="col">
<div class="card shadow-none border bg-gradient-dark-start-1 h-100">
<div class="card-body p-20 d-flex justify-content-between align-items-center">
<div>
<p class="fw-medium text-primary-light mb-1">Total Income</p>
<h6 class="mb-0">Rs. {{ number_format($totalIncome ?? 0,2) }}</h6>
</div>
<div class="w-50-px h-50-px bg-danger rounded-circle d-flex justify-content-center align-items-center">
<iconify-icon icon="mdi:cash" class="text-white text-2xl"></iconify-icon>
</div>
</div>
</div>
</div>

<!-- Today's Income -->
<div class="col">
<div class="card shadow-none border bg-gradient-start-3 h-100">
<div class="card-body p-20 d-flex justify-content-between align-items-center">
<div>
<p class="fw-medium text-primary-light mb-1">Today's Income</p>
<h6 class="mb-0">Rs. {{ number_format($todayIncome ?? 0,2) }}</h6>
</div>
<div class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
<iconify-icon icon="mdi:currency-lkr" class="text-white text-2xl"></iconify-icon>
</div>
</div>
</div>
</div>

</div>


<!-- ================= Sales & Earnings Charts ================= -->
<div class="row gy-4 mt-4">

    <!-- Sales Chart -->
    <div class="col-xxl-6 col-xl-12">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-lg mb-0">Orders (Last 12 Months)</h6>
                </div>
                <div id="salesChart" class="pt-3"></div>
            </div>
        </div>
    </div>

    <!-- Earnings Chart -->
    <div class="col-xxl-6 col-xl-12">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="text-lg mb-0">Income (Last 12 Months)</h6>
                </div>
                <div id="earningsChart" class="pt-3"></div>
            </div>
        </div>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
 var optionsSales = {
      series: [{
          name: "Sales",
          data: {!! json_encode($salesData ?? []) !!},
      }],
      chart: {
          height: 264,
          type: 'line',
          toolbar: { show: false },
          zoom: { enabled: false },
          dropShadow: {
              enabled: true,
              top: 6,
              left: 0,
              blur: 4,
              color: "#487FFF88",
              opacity: 0.9,
          },
      },
      stroke: {
          curve: 'smooth',
          colors: ['#487FFF'],
          width: 3
      },
      markers: {
          size: 0,
          strokeWidth: 3,
          hover: { size: 8 }
      },
      dataLabels: { enabled: false },
      tooltip: {
          enabled: true,
          x: { show: true },
          y: { show: false },
          z: { show: false }
      },
      grid: {
          row: {
              colors: ['transparent', 'transparent'],
              opacity: 0.5
          },
          borderColor: '#D1D5DB',
          strokeDashArray: 3,
      },
      xaxis: {
          categories: {!! json_encode($months ?? []) !!},
          tooltip: { enabled: false },
          labels: {
              formatter: function (value) { return value; },
              style: { fontSize: "14px" }
          },
          axisBorder: { show: false },
          crosshairs: {
              show: true,
              width: 20,
              stroke: { width: 0 },
              fill: {
                  type: 'solid',
                  color: '#487FFF40'
              }
          }
      },
      yaxis: { title: { text: "Bookings" } }
  };
  var salesChart = new ApexCharts(document.querySelector("#salesChart"), optionsSales);
  salesChart.render();

</script>

<script>
var optionsEarnings = {
    series: [{
        name: "Earnings",
        data: {!! json_encode($earningsData ?? []) !!},
    }],
    chart: {
        height: 264,
        type: 'line',
        toolbar: { show: false },
        zoom: { enabled: false },
        dropShadow: {
            enabled: true,
            top: 6,
            left: 0,
            blur: 4,
            color: "#FF9F2988",
            opacity: 0.9,
        },
    },
    stroke: {
        curve: 'smooth',
        colors: ['#FF9F29'],
        width: 3
    },
    markers: {
        size: 4,                     // size of marker
        colors: ['#FF9F29'],         // marker color
        strokeColors: '#fff',        // border around marker
        strokeWidth: 2,
        hover: {
            size: 6,                 // size when hovering
            sizeOffset: 0,
            fillColor: '#FF9F29',    // fill on hover
            strokeColor: '#fff'      // border on hover
        }
    },
    dataLabels: { enabled: false },
    tooltip: {
        enabled: true,
        marker: {
            show: true,
            fillColors: ['#FF9F29'], // tooltip marker color matches line
            strokeColors: '#fff',
        },
        x: { show: true },
        y: { show: true },
    },
    grid: {
        row: {
            colors: ['transparent', 'transparent'],
            opacity: 0.5
        },
        borderColor: '#D1D5DB',
        strokeDashArray: 3,
    },
    xaxis: {
        categories: {!! json_encode($months ?? []) !!},
        tooltip: { enabled: false },
        labels: { style: { fontSize: "14px" } },
        axisBorder: { show: false },
        crosshairs: {
            show: true,
            width: 20,
            stroke: { width: 0 },
            fill: { type: 'solid', color: '#FF9F2940' }
        }
    },
    yaxis: { title: { text: "Amount (Rs.)" } }
};

var earningsChart = new ApexCharts(document.querySelector("#earningsChart"), optionsEarnings);
earningsChart.render();
</script>


@endsection