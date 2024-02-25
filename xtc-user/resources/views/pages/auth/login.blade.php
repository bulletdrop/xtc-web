@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          </div>
          <div class="col-md-8 ps-md-6">
            <div class="auth-form-wrapper px-6 py-6">
                <a href="#" style="color:rgb(0, 255, 213)" class="noble-ui-logo d-block mb-2">XTC<span></span></a>
              <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
                <div class="mb-3">
                  <label for="userEmail" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" placeholder="Username">
                </div>
                <div class="mb-3">
                  <label for="userPassword" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" autocomplete="current-password" placeholder="Password">
                </div>
                <div>
                  <button id="login" class="btn btn-primary me-2 mb-2 mb-md-0">Login</button>
                </div>
                <a href="{{ url('/auth/register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<script src="{{ asset('page/login.js') }}"></script>
@endsection
