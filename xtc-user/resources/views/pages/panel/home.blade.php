@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    @if (isset($username))
        <h4 class="mb-3 mb-md-0">Welcome {{$username}}</h4>
    @else
        <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
    @endif
  </div>
</div>

<div class="row">
  <div class="col-12 col-xl-12 stretch-card">
    <div class="row flex-grow-1">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
              <h6 class="card-title mb-0">Active subscriptions</h6>
            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <h3 class="mb-2">{{$licenseCount}}</h3>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
              <h6 class="card-title mb-0">Open support tickets</h6>
            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <h3 class="mb-2">{{$openTicketCount}}</h3>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- row -->



<div class="row">
  <div class="col-lg-7 col-xl-12 stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Active subscriptions</h6>
          <div class="dropdown mb-2">
            <button class="btn btn-primary mb-1 mb-md-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Redeem</button>
          </div>
        </div>
        <div class="collapse mb-4" id="collapseExample">
            <div class="card card-body">
                <div class="mb-3">
                    <label for="exampleInputUsername1" class="form-label">License key</label>
                    <input type="text" class="form-control" id="licensekey" autocomplete="off" placeholder="License key">
                </div>
                <button class="btn btn-success" id="redeem">Redeem</button>
            </div>

        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0" id="licenses-table">
            <thead>
              <tr>
                <th class="pt-0">Product</th>
                <th class="pt-0">Days left</th>
                <th class="pt-0">Freezed</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($licenses as $license)
                    <tr>
                        <td>{{$license->pid}}</td>
                        <td>{{$license->days_left}}</td>
                        @if ($license->frozen == 1)
                            <td><span class="badge bg-danger">Yes</span></td>
                        @else
                            <td><span class="badge bg-success">No</span></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
          </table>
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
  <script src="{{ asset('page/home.js') }}"></script>
@endpush
