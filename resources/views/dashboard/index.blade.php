@extends('layouts.app')

@section('content')
{{-- <h1>{{ dd(Auth::user())}}</h1> --}}
<?php 
	// $user_detail = Auth:: user();
	// echo $user_detail->firstname;
?>


@if(Auth::user()->account_role===1)
	<h4 class="lead text-center">User: {{Auth::user()->firstname}} You are registered as an <i>Admin</i></h4>
@else
	<h4 class="lead text-center">User: {{Auth::user()->firstname}} You are registered as a <i>regular user</i></h4>
@endif

@endsection