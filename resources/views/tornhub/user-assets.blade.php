@extends('layouts.app')

@section('content')
	<div class="row">
		<!-- list links -->
		<div class="col-md-3">
			<ul>
				<li><a href="">Current holdings</a></li>
				<li><a href="">My Transactions</a></li>
			</ul>
		</div>

		<!-- borrowed items -->
		<div class="col-md-9">
			<div class="row">
			@foreach(\App\Transaction::all() as $transaction)
				@if($transaction->user_id === Auth::user()->id && $transaction->transaction_status === //trans id of borrowed)
					<div class="col-md-4">
						<div class="card">
							<div class="card-header">
								{{ $transaction->books->title }}
							</div>
							<form action="/book/return" method="POST">
								{{ method_field("PATCH") }}
								<input type="number" name="transaction_id" value="{{$transaction->id}}" hidden>
								<button type="submit">Return</button>
							</form>
						</div>
					</div>
				@endif
			@endforeach
			</div>
		</div>

		<!-- transactions -->
		<div class="col-md-9">
			<table>
				<thead>
					<tr>
						<td>id</td>
						<td>date</td>
					</tr>
				</thead>
				<tbody>
					@foreach(\App\Transaction::all() as $transaction)
					<tr>
						<td>{{$transaction->id}}</td>
						<td>{{$transaction->created_at}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection