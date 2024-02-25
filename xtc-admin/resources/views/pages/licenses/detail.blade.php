@extends('layout.master')

@push('plugin-styles')
  <!-- Plugin css import here -->
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">License details</h6>
          <form data-bitwarden-watching="1" method="POST" action="/licenses/edit?lid={{$license->lid}}">
            @csrf
            <div class="mb-3">
              <label for="license_key" class="form-label">License key</label>
              <input type="text" name="license_key" class="form-control" id="license_key" value="{{$license->license_key}}" placeholder="License key">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlSelect1" class="form-label">User</label>
                <select class="form-select" id="uid" name="uid">
                    @if ($license->uid == null)
                        <option selected="" value="0">No user</option>
                        @foreach ($allUsers as $user)
                            <option value="{{$user->uid}}">{{$user->username}}</option>
                        @endforeach
                    @else
                    @foreach ($allUsers as $user)
                        @if ($license->uid == $user->uid)
                            <option selected value="{{$user->uid}}">{{$user->username}}</option>
                        @else
                            <option value="{{$user->uid}}">{{$user->username}}</option>
                        @endif
                    @endforeach
                    @endif
                </select>
              </div>

            <div class="mb-3">
              <label for="days_left" class="form-label">Days left</label>
              <input type="number" class="form-control" name="days_left" id="days_left" value="{{$license->days_left}}">
            </div>

            <div class="mb-3">
                <label for="exampleFormControlSelect1" class="form-label">Product</label>
                <select class="form-select" id="exampleFormControlSelect1" name="pid">
                  <option selected="" value="{{$license->pid}}">{{$license->product->product_name}}</option>
                    @foreach ($allProducts as $product)
                            @if ($license->pid != $product->pid)
                                <option value="{{$product->pid}}">{{$product->product_name}}</option>
                            @endif
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <div class="form-check form-check-inline">
                    <input type="checkbox" class="form-check-input" name="frozen" id="checkInlineChecked"
                        @if ($license->frozen == 1)
                        checked=""
                        @endif
                    >
                  <label class="form-check-label" for="checkInlineChecked">
                    Frozen
                  </label>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </form>
        <button onclick="deleteLicense({{$license->lid}})" class="btn btn-danger mt-2" type="button">Delete</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('plugin-scripts')

@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/license-detail.js') }}"></script>
@endpush
