@extends('layouts.app')

@section('content')
	<div class="row">
		<!-- list links -->
		<div class="col-md-3">
			<div id="user-list" class="list-group" role="tablist">
				<a class="list-group-item list-group-item-action active" data-toggle="list" href="#my-items" role="tab">Current Items</a>
				<a class="list-group-item list-group-item-action" href="#my-transactions" data-toggle="list" role="tab">My Transactions</a>
				<a class="list-group-item list-group-item-action" href="#my-requests" data-toggle="list" role="tab">Books I Requested</a>
			</div>
		</div>

		<!-- borrowed items -->
		<div class="tab-content col-md-9">

			<div id="my-items" class="tab-pane fade show active col-md-9" role="tabpanel">
				<div class="row">

					<?php $transaction_count = 0; ?>
					@foreach(Auth::user()->transactions as $user_transaction)
						@if($user_transaction->statuses->name == 'received')
							<?php $transaction_count++; ?>
						@endif
					@endforeach

					@if($transaction_count <= 0)
						<div class="col-md-12">
							<h5 class="text-center">You're bag is currently empty.</h5>
						</div>
					@else
						@foreach(\App\Transaction::all() as $transaction)
							@if($transaction->users->id === Auth::user()->id && $transaction->statuses->name == "received")
								<div class="card">
									<div class="card-header">
										{{$transaction->books->title}}
									</div>
									<div class="card-body">
										<form action="/book/return" method="POST">
											{{ method_field("PATCH") }}
											<input type="number" name="transaction_id" value="{{$transaction->id}}" hidden>
											<button type="submit">Return</button>
										</form>
									</div>
								</div>
							@endif
						@endforeach
					@endif
				</div>
			</div>

			<div id="my-transactions" class="col-md-11 tab-pane fade" role="tabpanel">
				@if(Auth::user()->transactions->count() !== 0)
				<table class="table">
					<thead class="thead-dark">
						<tr>
							<th scope="col">Transaction ID</th>
							<th scope="col">Transaction Date</th>
							<th scope="col">Book Borrowed</th>
							<th scope="col">Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach(\App\Transaction::all() as $transaction)
							@if($transaction->user_id === Auth::user()->id)
							<tr>
								<td>{{$transaction->id}}</td>
								<td>{{$transaction->created_at->diffForHumans()}}</td>
								<td>{{$transaction->books->title}}</td>
								<td>{{$transaction->statuses->name}}</td>
							</tr>
							@endif
						@endforeach
					</tbody>
				</table>
				@else
					<h5 class="text-center">You do not have any transactions yet :(</h5>
				@endif
			</div>

			<div id="my-requests" class="col-md-12 tab-pane fade" role="tabpanel">
				<?php $request_count = 0; ?>
				@foreach(Auth::user()->transactions as $user_transaction)
					@if($user_transaction->statuses->name == 'pickup')
						<?php $request_count++; ?>
					@endif
				@endforeach
				@if($request_count === 0)
					@foreach(Auth::user()->transactions as $user_transaction)
					<div class="row">
						@if($user_transaction->statuses->name == 'pickup')
						<div class="card">
							<div class="card-header">
								<h5 class="card-text">{{$user_transaction->books->title}}</h5>
							</div>
							<div class="card-body">
								<p>{{$user_transaction->books->description}}</p>
							</div>
							<div class="card-footer">
								<p>For pickup</p>
							</div>
						</div>
						@elseif($user_transaction->statuses->name == 'pending')
						<div class="card">
							<div class="card-header">
								<h5 class="card-text">{{$user_transaction->books->title}}</h5>
							</div>
							<div class="card-body">
								<p>Author: {{$user_transaction->books->authors->name}}</p>
								<p>Category: {{$user_transaction->books->categories->name}}</p>
								<p>Description:</p>
								<p>{{$user_transaction->books->description}}</p>
							</div>
							<div class="card-footer">
								<p>Pending</p>
							</div>
						</div>
						@endif
					</div>
					@endforeach
				@else
					<h5>You're requests being processed</h5>
				@endif
			</div>

		</div>
		
@endsection