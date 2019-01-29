@extends('layouts.app')

@section('content')
@guest
@if(Auth::user()->account_role!==1)
	<div class="container">
		<h1>You dont look like an admin to me. hmmmm</h1>
		<p class="lead">How about going back to the<a href="#"> home page </a></p>
	</div>
@endif
@else	
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
			<button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#add-book">Add Book</button>
			@foreach($collection['books'] as $book)
				<p>{{$book->name}}</p>
			@endforeach
		</div>
		<div class="col-md-4">
			<p class="lead">Manage Authors</p>
			<button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#add-author">Add Author</button>
			@foreach($collection['authors'] as $author)
				<p>{{$author->name}}</p>
			@endforeach
		</div>

		<div class="col-md-4">
			<p class="lead">Manage Statuses</p>
			<button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#add-status">Add Status</button>
			<ul>
			@foreach($collection['statuses'] as $status)
				<li><p>{{$status->name}}</p></li>
			@endforeach
			</ul>
			{{-- <a href="#">Add Status</a> --}}
			<!-- <form action="/addStatus" method="POST">
				{{csrf_field()}}
				<div class="form-group">
					<label>Status Name</label>
					<input type="text" name="status" class="form-control">
				</div>
				<button id="add-status" type="submit" class="btn btn-success btn-block">Add Status</button>
			</form> -->
		</div>

		<div class="col-md-4">
			<p class="lead">Manage Categories</p>
			<button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#add-category">Add Category</button>
			<ul>
			@foreach($collection['categories'] as $category)
				<li><p>{{$category->name}}</p></li>
			@endforeach
			</ul>
		</div>

		<div class="col-md-4">
			<p class="lead">Manage Transactions</p>
			<button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#add-transaction">Add Transaction</button>
			<ul>
			@foreach($collection['transactions'] as $transaction)
				<li><p>{{$transaction->id}}</p></li>
			@endforeach
			</ul>
		</div>
	</div>

@endguest
@endsection
<div id="add-status" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Status</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="/addStatus" method="POST">
					@csrf
					<div class="form-group">
						<label>Status name:</label>
						<input class="form-control" type="text" name="status">
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="add-book" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Book</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="/addStatus" method="POST">
					@csrf
					<div class="form-group">
						<label>Book name:</label>
						<input class="form-control" type="text" name="status">
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="add-category" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Category</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="/addStatus" method="POST">
					@csrf
					<div class="form-group">
						<label>Category name:</label>
						<input class="form-control" type="text" name="status">
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div id="add-transaction" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Transaction</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="/addStatus" method="POST">
					@csrf
					<div class="form-group">
						<label>Transaction name:</label>
						<input class="form-control" type="text" name="status">
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Add</button>
				</form>
			</div>
		</div>
	</div>
</div>