@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Tickets</h6>
          <div class="table-responsive">
            <table id="dataTableExample" class="table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($tickets as $ticket)
                <tr>
                    <td><b>{{$ticket->title}}</b></td>
                    @switch($ticket->status)
                        @case(0)
                            <td><span class="badge bg-success">Waiting for admin</span></td>
                            @break
                        @case(1)
                            <td><span class="badge bg-primary">Waiting for user</span></td>
                            @break
                        @case(2)
                            <td><span class="badge bg-danger">Closed</span></td>
                            @break
                        @default
                            <td><span class="badge bg-danger">Error</span></td>
                    @endswitch

                    <td><a href="{{ url('/tickets/detail/?tid=' . $ticket->tid ) }}"><button class="btn btn-primary">View</button></a></td>
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
