@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Admins</h6>
          <div class="table-responsive">
            <table id="dataTableExample" class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>E-Mail</th>
                  <th>Active</th>
                  <th>Has to change password</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($admins as $admin)
                <tr>
                    <td>{{$admin->aid}}</td>
                    <td>{{$admin->username}}</td>
                    <td>{{$admin->email}}</td>
                    @if ($admin->active == 0)
                        <td><span class="badge bg-primary">No</span></td>
                    @else
                        <td><span class="badge bg-success">Yes</span></td>
                    @endif

                    @if ($admin->has_to_change_password == 0)
                        <td><span class="badge bg-primary">No</span></td>
                    @else
                        <td><span class="badge bg-danger">Yes</span></td>
                    @endif

                    <td><a href="{{ url('/admins/detail/?aid=' . $admin->aid ) }}"><button class="btn btn-primary">View</button></a></td>
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
