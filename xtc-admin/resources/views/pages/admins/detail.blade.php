@extends('layout.master')

@push('plugin-styles')
  <!-- Plugin css import here -->
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Admin details</h6>
          <form data-bitwarden-watching="1" method="POST" action="/admins/edit?aid={{$admin->aid}}">
            @csrf
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" name="username" class="form-control" id="username" value="{{$admin->username}}" placeholder="Username">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-Mail Address</label>
                <input type="email" name="email" class="form-control" id="email" value="{{$admin->email}}" placeholder="E-Mail Address">
            </div>

            <div class="mb-3">
                <label for="profile_picture_url" class="form-label">Profile picture url</label>
                <input type="text" name="profile_picture_url" class="form-control" id="profile_picture_url" value="{{$admin->profile_picture_url}}" placeholder="Profile picture url">
            </div>


            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                    <p class="text-muted mb-3">
                        Login tries with wrong password: {{$admin->failed_password_count}}</code>
                    </p>


                    <p class="text-muted mb-3">
                        Is active</code>
                    </p>

                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="active" name="active" @if($admin->active == 1 ) checked="" @endif >
                        <label class="form-check-label" for="active">

                        </label>
                    </div>


                      <p class="text-muted mb-3">
                        <br>Has to change password</code>
                      </p>
                      <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="has_to_change_password" name="has_to_change_password" @if($admin->has_to_change_password == 1 ) checked="" @endif >
                        <label class="form-check-label" for="has_to_change_password">

                        </label>
                      </div>

                      <div class="mb-3" id="has_to_change_password_div">
                        <label for="password" class="form-label"><br>Initial password (if password change)</label>
                        <input type="text" name="password" class="form-control" id="password" placeholder="Password">
                      </div>
                    </div>
                  </div>
                </div>
              </div>



            <button class="btn btn-success" type="submit">Save</button>
        </form>

        <a href="/admins/resetpasswordcount?aid={{$admin->aid}}"><button class="btn btn-primary mt-2">Reset failed password count</button></a>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('plugin-scripts')
  <!-- Plugin js import here -->
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/license-detail.js') }}"></script>
    <script src="{{ asset('assets/js/admin-editor.js') }}"></script>
@endpush

