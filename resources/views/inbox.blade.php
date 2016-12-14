@extends('home')

@section('content')
<div class="container">
    <div class="row">
        @section('subcontent')
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Inbox
                </div>

                <div class="panel-body">
                  <ul class="list-group">
                    @foreach($received as $one)
                    <li class="list-group-item">
                      <a href="inbox/{{$one['id']}}">{{$one['mail']['text']}} - {{$one['isRead']==0?'unread':'read'}}</a>
                    </li>
                    @endforeach
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function auto_load() {
  setTimeout(function(){
       location.reload();
  }, 5000);
};

auto_load();
</script>
@endsection
