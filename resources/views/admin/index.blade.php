@extends('layouts.app')

@if(Auth::user()->account_role===1)
@section('content')
	<div class="jumbotron text-center">
		<h4 class="display-4">Welcome {{Auth::user()->firstname}}</h4>
		<p class="lead">What would you like to do</p>
	</div>

	<div class="row">
		{{-- <div class="col-md-6"></div> --}}
		<div class="col-md-4">
			<p class="lead">Manage Users</p>
			<ul>
				@foreach($collection['users'] as $user)
				<li><a href="#">{{$user->firstname}}</a></li>
				@endforeach
			</ul>
		</div>
		<div class="col-md-4">
			<p class="lead">Manage Assets</p>
			<a href="#">Add Book</a>
			@foreach($collection['books'] as $book)
				<p>{{$book->name}}</p>
			@endforeach
		</div>
		<div class="col-md-4">
			<p class="lead">Manage Authors</p>
			<a href="#">Add Author</a>
			@foreach($collection['authors'] as $author)
				<p>{{$author->name}}</p>
			@endforeach
		</div>

		<div class="col-md-4">
			<p class="lead">Manage Statuses</p>
			<ul>
			@foreach($collection['statuses'] as $status)
				<li><p>{{$status->name}}</p></li>
			@endforeach
			</ul>
			{{-- <a href="#">Add Status</a> --}}
			<form action="/addStatus" method="POST">
				{{csrf_field()}}
				<div class="form-group">
					<label>Status Name</label>
					<input type="text" name="status" class="form-control">
				</div>
				<button id="add-status" type="submit" class="btn btn-success btn-block">Add Status</button>
			</form>
		</div>

		<div class="col-md-4">
			<p class="lead">Manage Categories</p>
			<a href="#">Add Category</a>
			<ul>
			@foreach($collection['categories'] as $category)
				<li><p>{{$category->name}}</p></li>
			@endforeach
			</ul>
		</div>

		<div class="col-md-4">
			<p class="lead">Manage Transactions</p>
			<a href="#">Add Transaction</a>
			<ul>
			@foreach($collection['transactions'] as $transaction)
				<li><p>{{$transaction->id}}</p></li>
			@endforeach
			</ul>
		</div>
	</div>

@else
	<div class="container">
		<h1>You dont look like an admin to me. hmmmm</h1>
		<p class="lead">How about going back to the<a href="#"> home page </a></p>
	</div>
@endif
@endsection