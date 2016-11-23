@extends('layouts.app')

@section('content')
    <div id="statistics">
        <stats :id="{{ $id }}"></stats>
    </div>
@endsection
