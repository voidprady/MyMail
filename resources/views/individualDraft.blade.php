@extends('home')

@section('subcontent')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">
          <p id="mailSubject">{{$draftDetails[0]['text']}}</p>
        </div>

        <div class="panel-body">
            <p>{{$draftDetails[0]['body']}} ---<span>{{$draftDetails[0]['user']['email']}}</span></p><br>
            <input class="form-control" id="recipients" type="text" placeholder="enter recipients with ','">
            <button class="btn btn-success" onclick="sendMail({{$draftDetails[0]['id']}})">Send</button>
            <button class="btn btn-target" onclick="trashMail({{$draftDetails[0]['id']}})">Trash it</button>
        </div>
    </div>
</div>
<script>
function trashMail(id) {
  var data = {};
  data.id = id;
  $.ajax({
    type : 'POST',
    url : 'trashDraft',
    data : data,
    success : function(){
      setTimeout(function(){
           location.replace('http://localhost/index.php/trash');
      }, 1000);
    }
  });
}
function sendMail(id) {
  var data = {};
  data.id = id;
  data.recipients = [];
  data.recipients = $('#recipients').val().split(',');
  if (!$('#recipients').val()) {
        alert('Error: recipient is missing.');
        return false;
  }else{
    $.ajax({
      type : 'POST',
      url : 'sendMail',
      data : data,
      // success : function (data) {
      //   location.replace('http://localhost/index.php/drafts');
      // }
    });
  }
};
</script>
@endsection('subcontent')
