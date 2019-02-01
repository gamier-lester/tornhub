@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-md-3">
			<ul class="list-group">
				<li class="list-group-item d-flex justify-content-between align-items-center">
					<a href="/dashboard">All</a>
				</li>
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
							@foreach(\App\Transaction::all() as $transaction)
								@if($transaction->user_id === Auth::user()->id)
									@if($transaction->book_id === $book->id)
									<form action="/book/return" method="POST" class="d-inline">
										@csrf
										{{ method_field("PATCH") }}
										<input type="number" name="transaction_id" value="{{$transaction->id}}" hidden>
										<button>Return</button>
									</form>
									@else
										<form action="/book/borrow" method="POST" class="d-inline">
											@csrf
											<input type="number" name="user_id" value="{{Auth::user()->id}}" hidden>
											<input type="number" name="book_id" value="{{$book->id}}" hidden>
											<button type="submit" class="btn btn-success">Borrow</button>
										</form>
									@endif
								@endif
							@endforeach
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			payment here
		</div>
	</div>

@endsection