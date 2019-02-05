@extends('layouts.app')

@section('content')
	<div id="user-assets" class="row justify-content-center">
		<!-- list links -->
		<div class="col-md-3">
			<div id="user-list" class="list-group" role="tablist">
				<a class="list-group-item list-group-item-action active" data-toggle="list" href="#my-items" role="tab">Current Items</a>
				<a class="list-group-item list-group-item-action" href="#my-transactions" data-toggle="list" role="tab">My Transactions</a>
				<a class="list-group-item list-group-item-action" href="#my-requests" data-toggle="list" role="tab">Books I Requested</a>
			</div>
		</div>

		<!-- borrowed items -->
		<div class="tab-content col-md-8">

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
								<div class="card" style="background-image: url('/{{$user_transaction->books->image_path}}');background-size: cover; background-repeat: no-repeat; height: 300px;">
									<div class="card-header">
										<h5 class="card-text"><mark>{{$transaction->books->title}}</mark></h5>
									</div>
									<div class="card-body">
										<p class="lead"><mark>Received: {{$transaction->updated_at->diffForHumans()}}</mark></p>
									</div>
									<div class="card-footer">
										<form action="/book/return" method="POST">
											@csrf
											{{ method_field("PATCH") }}
											<input type="number" name="transaction_id" value="{{$transaction->id}}" hidden>
											<button class="btn btn-block" type="submit">Return</button>
										</form>
									</div>
								</div>
							@endif
						@endforeach
					@endif
				</div>
			</div>

			<div id="my-transactions" class="col-sm-12 col-md-11 tab-pane fade" role="tabpanel">
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
						@foreach(\App\Transaction::paginate(10) as $transaction)
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
					<tfoot>
						<tr>
							<td>{{\App\Transaction::paginate(10)->links()}}</td>
						</tr>
					</tfoot>
				</table>
				@else
					<h5 class="text-center">You do not have any transactions yet :(</h5>
				@endif
			</div>

			<div id="my-requests" class="col-md-12 tab-pane fade" role="tabpanel">
				<?php $request_count = 0; ?>
				@foreach(Auth::user()->transactions as $user_transaction)
					@if($user_transaction->statuses->name == 'approved')
						<?php $request_count++; ?>
					@endif
				@endforeach
				@if($request_count !== 0)
				<div class="row justify-content-center">
					@foreach(Auth::user()->transactions as $user_transaction)
						@if($user_transaction->statuses->name == 'pending')
						<div class="col-md-4 mb-3">
							<div class="card" style="background-image: url('/{{$user_transaction->books->image_path}}');background-size: cover; background-repeat: no-repeat; height: 300px;">
								<div class="card-header">
									<h5 class="card-text"><mark>{{$user_transaction->books->title}}</mark></h5>
								</div>
								<div class="card-body">
									<p><mark>{{$user_transaction->books->description}}</mark></p>
								</div>
								<div class="card-footer">
									<p><mark>Requested: {{$user_transaction->created_at->diffForHumans()}}</mark></p>
									<button class="btn btn-block btn-disabled" disabled>Pending</button>
								</div>
							</div>
						</div>
						@elseif($user_transaction->statuses->name == 'approved')
						<div class="col-md-4 mb-3">
							<div class="card" style="background-image: url('/{{$user_transaction->books->image_path}}');background-size: cover; background-repeat: no-repeat; height: 300px;">
								<div class="card-header">
									<h5 class="card-text"><mark>{{$user_transaction->books->title}}</mark></h5>
								</div>
								<div class="card-body">
									<p><mark>{{$user_transaction->books->description}}</mark></p>
									<p><mark>Requested: {{$user_transaction->created_at->diffForHumans()}}</mark></p>
								</div>
								<div class="card-footer">
									<p><mark>Approved: {{$user_transaction->updated_at->diffForHumans()}}</mark></p>
									<form action="/requestReceive" method="POST">
										@csrf
										{{method_field("PATCH")}}
										<input type="number" name="transaction_id" value="{{$user_transaction->id}}" hidden>
										<button class="btn btn-success" type="submit">Receive Item</button>
									</form>
								</div>
							</div>
						</div>
						@endif
					@endforeach
				</div>
				@else
					<h5>You do not have any request to be processed right now...</h5>
				@endif
			</div>

		</div>
		
@endsection