@extends('home')

@section('subcontent')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-heading">
          <input type="text" class="form-control" id="subject" placeholder="Enter Subject">
        </div>

        <div class="panel-body">
            <textarea max="500" rows="11" cols="50" id="body" placeholder="Type your message"></textarea>
            <input type="file" class="input-file" name="file" id="file">
            <input type="text" class="form-control" id="recipients" placeholder="recipients separated with ," required>
            <button class="btn btn-default" id="saveDraft">Save as Draft</button>
            <button class="btn btn-primary" id="sendMail">send</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$('#saveDraft').on('click', function(event){
  var reader = new FileReader();
  var file = $('#file').prop('files')[0];
  var data = {};
  data.subject = $('#subject').val();
  data.body = $('#body').val();
  if(file){
    reader.onload = function(event) {
      data.attachment = event.target.result;

      if($('#subject').val() && $('#body').val()){
        $.ajax({
          type : 'POST',
          url : 'saveAsDraft',
          data : data,
          success : function() {
            window.location.href = 'drafts';
          }
        });
      }
    };
    reader.readAsDataURL(file);
  } else {
    if($('#subject').val() && $('#body').val()){
      $.ajax({
        type : 'POST',
        url : 'saveAsDraft',
        data : data,
        success : function() {
          window.location.href = 'drafts';
        }
      });
    }
  }
});

$('#sendMail').click(function(event) {
  var reader = new FileReader();
  var data = {};
  data.subject = $('#subject').val();
  data.body = $('#body').val();
  data.recipients = [];
  data.recipients = $('#recipients').val().split(',');
  var file = $('#file').prop('files')[0];
  if(file){
    reader.onload = function(event) {
      data.attachment = event.target.result;

      console.log("data", data);
      if (!$('#recipients').val()) {
        alert('Error: recipient is missing.');
        event.preventDefault();
        return false;
      }
      $.ajax({
        type : 'POST',
        url : 'send',
        data : data,
        success : function (data) {
          window.location.href = 'home';
        }
      });
    }
    reader.readAsDataURL(file);
  } else {
    $.ajax({
      type : 'POST',
      url : 'send',
      data : data,
      success : function (data) {
        window.location.href = 'home';
      }
    });
  };
});
</script>
@endsection
