@extends('layouts.app')

@section('content')
	<!-- {{Auth::user()->email}} -->
	<!-- {{Auth::user()->firstname}} -->
	<!-- {{Auth::user()->lastname}} -->
	{{Auth::user()->image}}
	<div class="container">
		<div class="row">
			<div class="col align-self-center">
				<div class="row justify-content-center">
					<div class="col-md-8 row text-center rounded border border-danger">
						<div class="col-md-12 p-3">
							<img class="img-fluid" src="/{{Auth::user()->image_path}}" alt="User Profile Picture">
							<form action="/user/update/image" method="POST" enctype="multipart/form-data" class="m-3">
								@csrf
								{{ method_field("PATCH") }}
								<input type="number" name="user_id" value="{{Auth::user()->id}}" hidden>
								<div class="custom-file">
									<input type="file" name="image" class="form-control-file">
								</div>
								@if(Session::has('success_message'))
								<span class="text-danger">{{Session::get('success_message')}}</span>
								@elseif(Session::has('error_message'))
								<span class="text-danger">{{Session::get('error_message')}}</span>
								@endif
								<button class="btn btn-block" type="submit">Update Image</button>
							</form>
						</div>
						
					</div>
					<div class="col-md-8 mt-3">
						<form action="/user/update" method="POST">
							@csrf
							{{ method_field("PATCH") }}
							<input type="number" name="user_id" value="{{Auth::user()->id}}" hidden>
							<div class="form-group row">
								<label for="update_profile_email" class="col-sm-2 col-form-label">Email: </label>
								<div class="col-sm-10">
									<input id="update_profile_email" class="form-control" type="email" name="email" value="{{Auth::user()->email}}" readonly>
								</div>
							</div>

							<div class="form-group row">
								<label for="update_profile_firstname" class="col-sm-2">Firstname: </label>
								<div class="col-sm-10">
									<input id="update_profile_firstname" class="form-control" type="text" name="firstname" value="{{Auth::user()->firstname}}">
								</div>
							</div>

							<div class="form-group row">
								<label for="update_profile_lastname" class="col-sm-2">Lastname: </label>
								<div class="col-sm-10">
									<input id="update_profile_lastname" class="form-control" type="text" name="lastname" value="{{Auth::user()->lastname}}">
								</div>
							</div>

							<div class="form-group row">
								<label for="update_profile_address" class="col-sm-2">Address: </label>
								<div class="col-sm-10">
									<textarea id="update_profile_address" class="form-control" name="address">{{Auth::user()->address}}</textarea>
								</div>
							</div>

							<button class="btn btn-block" type="submit">Update details</button>
		
						</form>
						@foreach(\App\User::all() as $user)
							@if($user->id === Auth::user()->id)
								<p>current transactions: {{$user->transactions->count()}}</p>
							@endif
						@endforeach
					</div>
					
				</div>

				
			</div>
		</div>
	</div>
	
@endsection