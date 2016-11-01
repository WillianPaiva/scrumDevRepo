@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$project->name}}</div>
                <div class="panel-body">
                    <label for="language" class="col-md-4 control-label">Desciption</label>
                    <div class="well">{{ $project->description }}</div>
                    <label for="language" class="col-md-4 control-label">Language</label>
                    <div class="well">{{ $project->language }}</div>
                    <label for="language" class="col-md-4 control-label">Version</label>
                    <div class="well">{{ $project->version }}</div>
                    <label for="language" class="col-md-4 control-label">Owner</label>
                    <div class="well">{{ App\User::find($project->user_id)->name }}</div>
                    <label for="language" class="col-md-4 control-label">Members</label>

                    <div class="well">
                    @foreach($project->members()->get() as $user)
                        </br>
                        {{ $user->name }}
                    @endforeach
                    </div>
                </div>

                <form class="form-horizontal" role="form" method="POST" action="addUser">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="user" class="col-md-4 control-label">User</label>
                        <div class="col-md-6">
                            <input  class="form-control" name="user" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <input type="hidden" name="id" value="{{$project->id}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Add
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
