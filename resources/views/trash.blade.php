@extends('home')

@section('subcontent')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">
          Trash
        </div>

        <div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item">trash from inbox------------------></li>
            @foreach($trashReceived as $one)
            <li class="list-group-item">
              {{$one['mail']['text']}} - {{$one['isRead']==0?'unread':'read'}}<br>
              {{$one['mail']['body']}}
            </li>
            @endforeach
            <li class="list-group-item">trash from sent & draft--------------------></li>
            @foreach($trashSent as $two)
            <li class="list-group-item">
              {{$two['text']}}<br>
              {{$two['body']}}
            </li>
            @endforeach
          </ul>
        </div>
    </div>
</div>
@endsection
