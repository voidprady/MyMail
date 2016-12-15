@extends('home')

@section('subcontent')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">
          <p id="mailSubject">{{$mailDetails[0]['text']}}</p>
        </div>

        <div class="panel-body">
            <p>{{$mailDetails[0]['body']}} ---<span>{{$mailDetails[0]['user']['email']}}</span></p><br>
            @if($mailDetails[0]['attachment']!=null)
            <img src="data:image/jpg;base64,{{$mailDetails[0]['attachment']}}">
            @endif
            <button class="btn btn-target" onclick="trashMail({{$mailDetails[0]['id']}})">Trash it</button>
        </div>
        <p>----thread starts----</p>
        @foreach($children as $child)
        <p>--------------------------------------------------------------------------------------------------------------------</p>
        <div class="panel-body">
            <p>{{$child['body']}} ---<span>{{$child['user']['email']}}</span></p><br>
            @if($child['attachment']!=null)
            <img src="data:image/jpg;base64,{{$child['attachment']}}">
            @endif
        </div>
        @endforeach
        <textarea name="name" rows="8" cols="40" class="form-control" id="mailbody" placeholder="enter text"></textarea><br>
        <button class="btn btn-primary" onclick="sendReply({{$mailDetails[0]['id']}})">reply</button>
        <input type="text" id="fwdId" class="form-control" placeholder="enter emails separated with ','">
        <button class="btn btn-success" onclick="forwardMail({{$mailDetails[0]['id']}})">forward</button>
    </div>
</div>

<script>
function trashMail(id) {
  var data = {};
  data.id = id;
  $.ajax({
    type : 'POST',
    url : 'trashMail',
    data : data,
    success : function(){
      setTimeout(function(){
           location.replace('http://localhost/trash');
      }, 1000);
    }
  });
}
function sendReply(toMail){
  var data = {};
  data.body = $('#mailbody').val();
  data.toMail = toMail;
  data.subject = $('#mailSubject').text();
  $.ajax({
    type : 'POST',
    url : 'sendReply',
    data : data,
    success : function(){
      setTimeout(function(){
           location.reload();
      }, 1000);
    }
  });
}

function forwardMail(toMail) {
  var data = {};
  data.toUsers = [];
  data.toUsers = $('#fwdId').val().split(',');
  data.body = $('#mailbody').val();
  data.subject = $('#mailSubject').text();
  data.toMail = toMail;

  $.ajax({
    type : 'POST',
    url : 'forwardMail',
    data : data,
    success : function () {
      setTimeout(function(){
           location.reload();
      }, 1000);
    }
  })
}

</script>
@endsection
