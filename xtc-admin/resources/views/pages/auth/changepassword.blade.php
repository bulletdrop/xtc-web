@extends('layout.master2')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-6 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pe-md-0">
            <div class="auth-side-wrapper" style="background-image: url({{ url('https://via.placeholder.com/219x452') }})">

            </div>
          </div>
          <div class="col-md-8 ps-md-0">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="noble-ui-logo d-block mb-2">XTC<span>Admin</span></a>
              <h5 class="text-muted fw-normal mb-4">Please change your password</h5>
              <form class="forms-sample">
                <div class="mb-3">
                  <label for="password" class="form-label">Current password</label>
                  <input type="password" class="form-control" id="cur_password" autocomplete="current-password" placeholder="Password">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New password</label>
                    <input type="password" class="form-control" id="new_password" autocomplete="new-password" placeholder="Password">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Confirm new password</label>
                    <input type="password" class="form-control" id="conf_new_password" autocomplete="new-password" placeholder="Password">
                </div>
                <div>
                </div>
              </form>
              <!--<button id="login-button" class="btn btn-primary me-2 mb-2 mb-md-0">Login</button>-->
              <button id="change-password" onclick="changePW()" class="btn btn-primary" type="button">
                Change
              </button>

              <!--
                <button class="btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
              </button>
              -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/changepw.js') }}"></script>
@endpush
