@extends('home')

@section('content')
<div class="container">
    <div class="row">
        @section('subcontent')
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Sent
                </div>

                <div class="panel-body">
                  <ul class="list-group">
                    @foreach($sent as $one)
                    <li class="list-group-item">
                      <a href="sent/{{$one['id']}}">{{$one['text']}}</a>
                    </li>
                    @endforeach
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  function trashMail(id){
    var data = {};
    data.id = id;
    console.log(id);
    $.ajax({
      type : 'POST',
      url : 'trashMail',
      data : data,
    });
    window.location.href = 'trash';
  }
</script>
@endsection
