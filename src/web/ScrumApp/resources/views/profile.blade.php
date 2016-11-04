@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <img src="/uploads/avatars/{{ $user->avatar }}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
            <h2>{{ $user->name }}'s Profile</h2>
            <h2> Contact: {{ $user->email }}</h2>
            <form enctype="multipart/form-data" action="/profile" method="POST">
                <label>Update Profile Image</label>
                <input type="file" name="avatar">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="submit" class="pull-right btn btn-sm btn-primary">
            </form>
        </div>
        <div class="col-md-10 col-md-offset-1">
          Projects contributing at:
          @if(count($memberOf)==0)
          <h2> No Projects </h2>
          @else
          <table class="table table-hover">
            <tr> <th>Name</th><th>description</th><th>Language</th><th>Version</th>
            </tr>
            @foreach ($memberOf as $memberOf)
            <tr>
                <td>{{$memberOf->name}}</td>
                <td>{{$memberOf->description}}</td>
                <td>{{$memberOf->language}}</td>
                <td>{{$memberOf->version}}
            </tr>
              @endforeach
          </table>
          @endif
        </div>
    </div>
</div>

@endsection

