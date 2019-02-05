@extends('layouts.app')

@section('content')
	<div class="row justify-content-center mx-0">
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
		<div class="col-md-8">
			<div class="row justify-content-center">
				@foreach($books as $book)
				<div class="col-md-5 mb-3">
					<div class="card">
						<img class="card-img-top" src="/{{$book->image_path}}" alt="Book Picture" style="width: 100%; height: 300px;">
						<div class="card-body">
							<h5 class="card-title">{{$book->title}}</h5>
							<p class="card-text">{{$book->authors->name}}</p>
						</div>
						<div class="card-footer">
							{{-- {{dd($book->transactions)}} --}}
							{{-- @foreach(\App\Transaction::all() as $transaction)
								@if($transaction->user_id === Auth::user()->id)
									@if($transaction->book_id === $book->id)
									<form action="/book/return" method="POST" class="d-inline">
										@csrf
										{{ method_field("PATCH") }}
										<input type="number" name="transaction_id" value="{{$transaction->id}}" hidden>
										<button class="btn btn-block bg-primary" type="submit">Return</button>
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
							@endforeach --}}
							{{-- @if($book->transactions->transaction_status === 6)
								<form action="/book/return" method="POST" class="d-inline">
									@csrf
									{{ method_field("PATCH") }}
									<input type="number" name="transaction_id" value="{{$book->transactions->id}}" hidden>
									<button class="btn btn-block bg-primary" type="submit">Return</button>
								</form>
							@else
								<form action="/book/borrow" method="POST" class="d-inline">
									@csrf
									<input type="number" name="user_id" value="{{Auth::user()->id}}" hidden>
									<input type="number" name="book_id" value="{{$book->id}}" hidden>
									<button type="submit" class="btn btn-success">Borrow</button>
								</form>
							@endif --}}
							<?php $stat_count = 0; $transaction_id = 0?>
							@foreach(\App\Transaction::all() as $transaction)
								@if($transaction->user_id === Auth::user()->id && $transaction->book_id === $book->id && ($transaction->statuses->name === 'approved' || $transaction->statuses->name === 'received'))
									{{-- if transaction is approved --}}
								<?php $stat_count = 2; $transaction_id = $transaction->id;?>
								@elseif($transaction->user_id === Auth::user()->id && $transaction->book_id === $book->id && $transaction->statuses->name === 'pending')
									{{-- if transaction is still pending --}}
									<?php $stat_count = 1; $transaction_id = $transaction->id;?>
								@endif
							@endforeach
							@if($stat_count === 1)
								<button class="btn btn-block bg-primary disabled" type="submit">Pending</button>
							@elseif($stat_count === 2)
								<form action="/book/return" method="POST" class="d-inline">
									@csrf
									{{ method_field("PATCH") }}
									<input type="number" name="transaction_id" value="{{$transaction_id}}" hidden>
									<button class="btn btn-block bg-primary" type="submit">Return</button>
								</form>
							@else
								<form action="/book/borrow" method="POST" class="d-inline">
									@csrf
									<input type="number" name="user_id" value="{{Auth::user()->id}}" hidden>
									<input type="number" name="book_id" value="{{$book->id}}" hidden>
									<button type="submit" class="btn btn-success">Borrow</button>
								</form>
							@endif
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>

@endsection