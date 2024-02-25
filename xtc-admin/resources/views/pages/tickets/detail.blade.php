@extends('layout.master')

@push('plugin-styles')
  <!-- Plugin css import here -->
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
            @if ($ticket->is_closed == 0)
                <a href="/tickets/close?tid={{$ticket->tid}}"><button type="button" class="btn btn-danger">Close ticket</button></a>
            @else
                <a href="/tickets/open?tid={{$ticket->tid}}"><button type="button" class="btn btn-primary">Open ticket</button></a>
            @endif
            <br><br>
            <img class="wd-30 ht-30 rounded-circle mb-2" src="{{$profile_picture_url}}" alt="profile">
            <h6 class="card-title">{{$username}}</h6>



            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" value="{{$ticket->title}}" disabled>
            </div>

            <div class="mb-3">
              <label for="message" class="form-label">Description</label>
              <textarea required class="form-control" id="message" name="message" disabled rows="5">{{$ticketMessages[0]->message}}</textarea>
            </div>
        </div>
      </div>
    </div>
</div>
@foreach ($ticketMessages as $ticketMessage)
@if ($loop->first) @continue @endif
    @if ($ticketMessage->aid != 0)
    <div class="row ">
        <div class="col-md-6  grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
                <img class="wd-30 ht-30 rounded-circle mb-2" src="{{$ticketMessage->profile_picture_url}}" alt="profile">
                <h6 class="card-title">{{$ticketMessage->username}}</h6>

                <div class="mb-3">
                  <label for="message" class="form-label">Description</label>
                  <textarea required class="form-control" id="message" name="message" disabled rows="5">{{$ticketMessage->message}}</textarea>
                </div>
            </div>
          </div>
        </div>
    </div>
    @else
    <div class="row justify-content-end">
        <div class="col-md-6 col-md-offset-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
                <img class="wd-30 ht-30 rounded-circle mb-2" src="{{$profile_picture_url}}" alt="profile">
                <h6 class="card-title">{{$username}}</h6>

                <div class="mb-3">
                  <label for="message" class="form-label">Answer</label>
                  <textarea required class="form-control" id="message" name="message" disabled rows="5">{{$ticketMessage->message}}</textarea>
                </div>
            </div>
          </div>
        </div>
    </div>
    @endif
@endforeach
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Answer</h6>
          <form data-dwl-watching="1" method="POST" action="/tickets/answer?tid={{$ticket->tid}}">
            @csrf
            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea required class="form-control" id="message" name="message" rows="5"></textarea>
            </div>

            <button class="btn btn-primary" type="submit">Send</button>
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
