@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Licenses</h6>
          <a href="{{ url('/licenses/add' ) }}"><button type="button" class="btn btn-primary mb-2">Generate licenses</button></a>
          <div class="table-responsive">
            <table id="dataTableExample" class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>License key</th>
                  <th>Product</th>
                  <th>Days left</th>
                  <th>User</th>
                  <th>Frozen</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($licenses as $license)
                <tr>
                    <td>{{$license->lid}}</td>
                    <td>{{$license->license_key}}</td>
                    <td>{{$license->product}}</td>
                    <td>{{$license->days_left}}</td>
                    <td>{{$license->user}}</td>
                    <td>{{$license->status}}</td>
                    <td><a href="{{ url('/licenses/detail/?lid=' . $license->lid ) }}"><button class="btn btn-primary">View</button></a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
