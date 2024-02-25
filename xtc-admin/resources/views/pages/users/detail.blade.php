@extends('layout.master')

@push('plugin-styles')
  <!-- Plugin css import here -->
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">User details</h6>
          <form data-bitwarden-watching="1" method="POST" action="/users/edit?uid={{$user->uid}}">
            @csrf
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" name="username" class="form-control" id="username" value="{{$user->username}}" placeholder="Username">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-Mail Address</label>
                <input type="email" name="email" class="form-control" id="email" value="{{$user->email}}" placeholder="E-Mail Address">
            </div>

            <div class="mb-3">
                <label for="profile_picture_url" class="form-label">Profile picture url</label>
                <input type="text" name="profile_picture_url" class="form-control" id="profile_picture_url" value="{{$user->profile_picture_url}}" placeholder="Profile picture url">
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Bans</h4>
                        @if ($bans != null)
                            @foreach ($bans as $ban)
                                <p><b>Ban ID:</b> {{$ban->blid}}</p>
                                <p><b>Reason:</b> {{$ban->reason}}</p>
                                <br>
                            @endforeach
                        @else
                            <p>No bans found</p>
                        @endif

                    </div>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">HWID</h4>
                        @if ($hwid == null)
                            <p>No HWID found</p>
                        @else
                            <p><b>Core count:</b> {{$hwid->core_count}}</p>
                            <p><b>Disk serial:</b> {{$hwid->disk_serial}}</p>
                            <p><b>Mainboard name:</b> {{$hwid->mainboard_name}}</p>
                            <p><b>Windows username:</b> {{$hwid->winuser}}</5h>
                            <p><b>HWID Hash:</b> {{$hwid->hwid_hash}}</p>
                            <p><b>GUID:</b> {{$hwid->guid}}</p>
                        @endif
                    </div>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                        @foreach ($failed_hwids as $fhwid)
                            <h4 class="card-title">Failed HWID {{$fhwid->fhid}}</h4>
                            <p><b>Core count:</b> {{$fhwid->core_count}}</p>
                            <p><b>Disk serial:</b> {{$fhwid->disk_serial}}</p>
                            <p><b>Mainboard name:</b> {{$fhwid->mainboard_name}}</p>
                            <p><b>Windows username:</b> {{$fhwid->winuser}}</5h>
                            <p><b>HWID Hash:</b> {{$fhwid->hwid_hash}}</p>
                            <p><b>GUID:</b> {{$fhwid->guid}}</p>
                            <a href="/users/setHWID?fhid={{$fhwid->fhid}}"><button class="btn btn-danger" type="button">Set as new HWID</button></a>
                            <br><br>
                        @endforeach
                    </div>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Licenses</h4>
                      <p class="text-muted mb-3">
                        Licenses assigned to this user</code>
                      </p>
                      <div class="table-responsive pt-3">
                        <table class="table table-dark">
                          <thead>
                            <tr>
                              <th>
                                #
                              </th>
                              <th>
                                License key
                              </th>
                              <th>
                                Product
                              </th>
                              <th>
                                Days left
                              </th>
                              <th>
                                Action
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($licenses as $license)
                            <tr>
                                <td>{{$license->lid}}</td>
                                <td>{{$license->license_key}}</td>
                                <td>{{$license->product->product_name}}</td>
                                <td>{{$license->days_left}}</td>
                                <td><a href="/licenses/detail/?lid={{ $license->lid  }}"><button class="btn btn-primary" type="button">View</button></a></td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="bsod" name="bsod" @if($user->bsod == 1 ) checked="" @endif >
                <label class="form-check-label" for="exampleCheck1">
                  BSOD
                </label>
              </div>

            <button class="btn btn-primary" type="submit">Save</button>
            @if ($user->is_banned == 0)
                <a href="/users/ban?uid={{$user->uid}}"><button class="btn btn-danger" type="button">Ban</button></a>
            @else
                <a href="/users/unban?uid={{$user->uid}}"><button class="btn btn-danger" type="button">Unban</button></a>
            @endif
        </form>

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
@endpush
