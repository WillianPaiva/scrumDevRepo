@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="container-project">
            @if( !empty( json_decode( $projects) ) )
                @foreach ($projects as $project)
                    <div class="panel panel-project">
                        <div class="panel-heading">{{ $project->name }}</div>
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>Description :</td>
                                    <td>{{ $project->description }}</td>
                                </tr>
                                <tr>
                                    <td>Language :</td>
                                    <td>{{ $project->language }}</td>
                                </tr>
                                <tr>
                                    <td>Version :</td>
                                    <td>{{ $project->version }}</td>
                                </tr>
                            </table>
                            <a href="{{route('showProject', $project->id)}}" class="btn btn-primary">
                                open
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="panel panel-default">
                    <div class="panel-heading">List Profile</div>
                    <div class="panel-body">
                        <h1>No Project</h1>
                    </div>
                </div>
        </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/project/add') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-fixed">
                    New Project
                </button>
            </form>
    </div>

@endsection
