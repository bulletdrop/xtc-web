@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
  </div>
</div>

<div class="row">
  <div class="col-12 col-xl-12 stretch-card">
    <div class="row flex-grow-1">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
              <h6 class="card-title mb-0">Users</h6>
            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <h3 class="mb-2">{{$currentStats->users}}</h3>
                <div class="d-flex align-items-baseline">
                </div>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="userChart" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
              <h6 class="card-title mb-0">Licenses</h6>
            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <h3 class="mb-2">{{$currentStats->licenses}}</h3>
                <div class="d-flex align-items-baseline">
                </div>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="licensesChart" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
              <h6 class="card-title mb-0">Admins</h6>
            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <h3 class="mb-2">{{$currentStats->admins}}</h3>
                <div class="d-flex align-items-baseline">
                </div>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="adminChart" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- row -->
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>

@endpush

@push('custom-scripts')
    <script>
          $(function() {
  'use strict'



  var colors = {
    primary        : "#6571ff",
    secondary      : "#7987a1",
    success        : "#05a34a",
    info           : "#66d1d1",
    warning        : "#fbbc06",
    danger         : "#ff3366",
    light          : "#e9ecef",
    dark           : "#060c17",
    muted          : "#7987a1",
    gridBorder     : "rgba(77, 138, 240, .15)",
    bodyColor      : "#b8c3d9",
    cardBg         : "#0c1427"
  }

  var fontFamily = "'Roboto', Helvetica, sans-serif"





  // New Customers Chart
  if($('#userChart').length) {
    var options1 = {
      chart: {
        type: "line",
        height: 60,
        sparkline: {
          enabled: !0
        }
      },
      series: [{
        name: '',
        data: [
            @foreach ($stats as $stat)
                {{ $stat->users }},
            @endforeach
        ]
      }],
      xaxis: {
        type: 'datetime',
        categories: [
            @foreach ($stats as $stat)
                "{{ $stat->created_at }}",
            @endforeach
        ],
      },
      stroke: {
        width: 2,
        curve: "smooth"
      },
      markers: {
        size: 0
      },
      colors: [colors.primary],
    };
    new ApexCharts(document.querySelector("#userChart"),options1).render();
  }
  // New Customers Chart - END




  // Orders Chart
  if($('#licensesChart').length) {
    var options2 = {
      chart: {
        type: "line",
        height: 60,
        sparkline: {
          enabled: !0
        }
      },
      plotOptions: {
        bar: {
          borderRadius: 2,
          columnWidth: "60%"
        }
      },
      colors: [colors.primary],
      series: [{
        name: '',
        data: [
            @foreach ($stats as $stat)
                {{ $stat->licenses }},
            @endforeach
            ]
      }],
      xaxis: {
        type: 'datetime',
        categories: [
            @foreach ($stats as $stat)
                "{{ $stat->created_at }}",
            @endforeach
        ],
      },
    };
    new ApexCharts(document.querySelector("#licensesChart"),options2).render();
  }
  // Orders Chart - END




  // Growth Chart
  if($('#adminChart').length) {
    var options3 = {
      chart: {
        type: "line",
        height: 60,
        sparkline: {
          enabled: !0
        }
      },
      series: [{
        name: '',
        data:   [
            @foreach ($stats as $stat)
                {{ $stat->admins }},
            @endforeach
                ]
      }],
      xaxis: {
        type: 'datetime',
        categories: [
            @foreach ($stats as $stat)
                "{{ $stat->created_at }}",
            @endforeach
        ],
      },
      stroke: {
        width: 2,
        curve: "smooth"
      },
      markers: {
        size: 0
      },
      colors: [colors.primary],
    };
    new ApexCharts(document.querySelector("#adminChart"),options3).render();
  }
  // Growth Chart - END






});

    </script>
@endpush
