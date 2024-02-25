@extends('layout.master')

@push('plugin-styles')
  <!-- Plugin css import here -->
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Open a ticket</h6>
          <form data-dwl-watching="1" method="POST" action="/tickets/store">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" required placeholder="Enter a title">
            </div>

            <div class="mb-3">
              <label for="message" class="form-label">Description</label>
              <textarea required class="form-control" id="message" name="message" rows="5"></textarea>
            </div>

            <button class="btn btn-primary" type="submit">Create ticket</button>
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
  <!-- Custom js here -->
@endpush
