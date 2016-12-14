@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2">
          <ul class="list-group">
            <li class="list-group-item"><a href="{{ url('/home') }}">Compose</a></li>
            <li class="list-group-item"><a href="{{ url('/inbox') }}">Inbox</a></li>
            <li class="list-group-item"><a href="{{ url('/sent') }}">Sent</a></li>
            <li class="list-group-item"><a href="{{ url('/drafts') }}">drafts</a></li>
            <li class="list-group-item"><a href="{{ url('/trash') }}">Trash</a></li>
          </ul>
        </div>
        @yield('subcontent')
    </div>
</div>
@endsection
