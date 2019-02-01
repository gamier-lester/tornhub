@extends('layouts.app')

@section('content')
	<!-- {{Auth::user()->email}} -->
	<!-- {{Auth::user()->firstname}} -->
	<!-- {{Auth::user()->lastname}} -->
	{{Auth::user()->image}}
	<form action="user/update/image" method="POST" enctype="multipart">
		@csrf
		{{ method_field("PATCH") }}
		<input type="file" name="image">
		<button>Update Image</button>
	</form>
	<form action="user/update" method="POST">
		@csrf
		{{ method_field("PATCH") }}
		<input type="email" name="email" value="{{Auth::user()->email}}">
		<input type="text" name="firstname" value="{{Auth::user()->firstname}}">
		<input type="text" name="lastname" value="{{Auth::user()->lastname}}">
		<button>Update details</button>
	</form>
	@foreach(\App\User as $user)
		@if($user->id === Auth::user()->id)
			<p>current transactions: {{$user->transactions->count()}}</p>
		@endif
	@endforeach
@endsection