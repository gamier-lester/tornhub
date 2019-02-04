@extends('layouts.app')

@section('content')
@guest
	<h5>OOOpsssss. You dont look like an admin to me</h5>
@elseif(Auth::user()->role_id === 2)
	<h5>OOOpsssss. You dont look like an admin to me</h5>
@else
	<div class="row">
		<div class="col-md-4">
			{{$collection['authors']->name}}
		</div>
		<div class="col-md-8">
			<div class="row">
				@foreach($collection['authors']->books as $author_works)
					<div class="col-md-3">
						<div class="card">
							<div class="card-body">
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
										<button type="submit">heal me papa</button>
									</form>
								@else
									<form action="/book/forceRemove/{{$collection['authors']->id}}" method="POST">
										@csrf
										{{method_field("DELETE")}}
										<input type="number" name="book_id" value="{{$author_works->id}}" hidden>
										<button>Remove perma</button>
									</form>
								@endif
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
@endif
@endsection
