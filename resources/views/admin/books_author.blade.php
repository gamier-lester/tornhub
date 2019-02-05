@extends('layouts.app')

@section('content')
@guest
	<h5>OOOpsssss. You dont look like an admin to me</h5>
@elseif(Auth::user()->role_id === 2)
	<h5>OOOpsssss. You dont look like an admin to me</h5>
@else
	<div class="jumbotron">
		<h3 class="jumbotron-text">{{$collection['authors']->name}}'s Collection</h3>
	</div>
	<div class="row justify-content-center">
	@foreach($collection['authors']->books as $author_works)
		<div class="col-md-3 mb-3">
			<div class="card">
				<div class="card-body">
					<img src="/{{$author_works->image_path}}" alt="Book cover" style="width: 100%; height: 300px;">
					<h5 class="card-text">{{$author_works->title}}</h5>
				</div>
				<div class="card-footer">
					{{-- button --}}
					@if($author_works->trashed())
						{{-- <button>Remove permanently</button> --}}
						{{-- <button>Recover me nigga</button> --}}
						<form action="/book/Restore/{{$collection['authors']->id}}" method="POST">
							@csrf
							{{method_field("PATCH")}}
							<input type="number" name="book_id" value="{{$author_works->id}}" hidden>
							<button class="btn btn-block btn-success" type="submit">heal me papa</button>
						</form>
					@else
						<form action="/book/forceRemove/{{$collection['authors']->id}}" method="POST">
							@csrf
							{{method_field("DELETE")}}
							<input type="number" name="book_id" value="{{$author_works->id}}" hidden>
							<button class="btn btn-block btn-danger" type="submit">Remove permanently</button>
						</form>
					@endif
				</div>
			</div>
		</div>
	@endforeach
	</div>
@endif
@endsection
