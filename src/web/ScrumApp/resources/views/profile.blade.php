@extends('layouts.app')

@section('content')
<table class="table table-hover">
<tr>
  <td>Nom:</td>
  <td>{{ Auth::user()->name }}</td>
</tr>
<tr>
  <td>Email:</td>
  <td> {{ Auth::user()->email }}</td>
</tr>
</table>
@endsection
