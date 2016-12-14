@extends('home')

@section('content')
<div class="container">
    <div class="row">
        @section('subcontent')
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                  Drafts
                </div>

                <div class="panel-body">
                  <ul class="list-group">
                    @foreach($draftMails as $one)
                    <li class="list-group-item">
                      <a href="drafts/{{$one['id']}}">{{$one['text']}}</a>
                    </li>
                    @endforeach
                  </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection('content')
