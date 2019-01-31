@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-md-3">
			<ul class="list-group">
				@foreach(\App\Category::all() as $category)
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<a href="/byCategory/{{$category->id}}">{{$category->name}}</a>
				</li>
				@endforeach
			</ul>
		</div>
		<div class="col-md-9">
			<div class="row">
				@foreach($books as $book)
				<div class="col-md-5">
					<div class="card">
						<img class="card-img-top" src="{{$book->image_path}}" alt="Book Picture">
						<div class="card-body">
							<h5 class="card-title">{{$book->title}}</h5>
							<p class="card-text">asdasd</p>
						</div>
						<div class="card-footer">
							<button>Borrow</button>
							<button>Return</button>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>

@endsection