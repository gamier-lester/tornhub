@extends('layouts.app')

@section('content')
	@foreach($users as $user)

	<div>{{$user->statuses}}</div>

	@endforeach
@endsection