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
              <form class="forms-sample">
                <div class="mb-3">
                  <label for="exampleInputUsername1" class="form-label">Username</label>
                  <input required type="text" class="form-control" id="username" id="exampleInputUsername1" autocomplete="Username" placeholder="Username">
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email address</label>
                  <input required type="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input required type="password" class="form-control" id="password" autocomplete="current-password" placeholder="Password">
                </div>
                <div class="mb-3">
                  <label for="confirmPassword" class="form-label">Confirm password</label>
                  <input required type="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirm password">
                </div>
                <div>
                    <button type="button" id="register" class="btn btn-primary me-2 mb-2 mb-md-0">Register</button>
                    <a href="{{ url('/auth/login') }}" class="d-block mt-3 text-muted">Already a user? Sign in</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script src="{{ asset('page/register.js') }}"></script>
</div>
@endsection
