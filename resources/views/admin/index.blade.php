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
				<p>{{$book->title}}</p>
				<button class="update-book" data-collection="{{$book}}">Update</button>
			@endforeach
		</div>
		<div class="col-md-4">
			<p class="lead">Manage Authors</p>
			<button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#add-author">Add Author</button>
			@foreach($collection['authors'] as $author)
				<p>{{$author->name}}</p>
				<button class="update-author" data-id="{{$author->id}}" data-name="{{$author->name}}">Update</button>
				<button class="delete-author" data-id="{{$author->id}}" data-name="{{$author->name}}">Remove</button>
			@endforeach
		</div>

		<div class="col-md-4">
			<p class="lead">Manage Statuses</p>
			<button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#add-status">Add Status</button>
			<ul>
			@foreach($collection['statuses'] as $status)
				<li>
					<p>{{$status->name}}</p>
					<button class="update-status" data-id="{{$status->id}}" data-name="{{$status->name}}">Update</button>
					<button class="delete-status" data-id="{{$status->id}}">Remove</button>
				</li>
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
				<li>
					<p>{{$category->name}}</p>
					<button class="update-category" data-id="{{$category->id}}" data-name="{{$category->name}}">Update</button>
					<button class="delete-category" data-id="{{$category->id}}" data-name="{{$category->name}}">- Remove</button>
				</li>
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
{{-- modals --}}
{{-- add status modal --}}
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

{{-- update status modal --}}
<div id="update-status" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Status</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="/updateStatus" method="POST">
					@csrf
					{{ method_field("PATCH") }}
					<input id="status_id" type="number" name="status_id" hidden>
					<div class="form-group">
						<label>Status name:</label>
						<input id="update-status-name" class="form-control" type="text" name="status">
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

{{-- delete status modal --}}
<div id="delete-status" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Status</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<p class="lead">Are You sure you want to delete <span id="delete_status_name"></span></p>
				<form id="delete-status-form" action="/deleteStatus" method="POST">
					@csrf
					{{ method_field("DELETE") }}
					<input id="status_delete_id" type="number" name="status_delete_id" hidden>
					<button class="btn btn-block btn-danger" type="submit">- Remove</button>
				</form>
			</div>
		</div>
	</div>
</div>

{{-- Add Books modal --}}
<div id="add-book" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Asset</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="/addAsset" method="POST">
					@csrf
					<div class="form-group">
						<label>Book Title:</label>
						<input class="form-control" type="text" name="title">
					</div>
					<div class="form-group">
						<label>Publish Year:</label>
						<input type="number" name="publishYear" min="1800" max="2019" required class="form-control" value="2019">
					</div>
					<div class="form-row mb-2">
						<label for="book-image">{{ __('Book picture') }}</label>           
	                    <div class="custom-file form-control">
	                        <input type="file" class="custom-file-input" id="book-image" name="image">
	                        <label class="custom-file-label" for="customFile">Choose file</label>
	                    </div>
					</div>
					<div class="form-group">
						<label>Category:</label>
						<select class="form-control" name="category">
							{{-- <option value="1">asdsad</option> --}}
							@foreach($collection['categories'] as $category)
							<option value="{{$category->id}}">{{$category->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Author:</label>
						<select class="form-control" name="author">
							@foreach($collection['authors'] as $author)
							<option value="{{$author->id}}">{{$author->name}}</option>
							@endforeach
						</select>
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

{{-- Update Books modal --}}
<div id="update-book" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Book</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="/updateAsset" method="POST">
					@csrf
					{{ method_field("PATCH") }}
					<input id="book_id" type="number" name="new_book_id" hidden>
					<div class="form-group">
						<label>Book Title:</label>
						<input class="form-control" type="text" name="new_title">
					</div>
					<div class="form-group">
						<label>Publish Year:</label>
						<input type="number" name="new_publishYear" min="1800" max="2019" required class="form-control" value="2019">
					</div>
					<div class="form-row mb-2">
						<label for="book-image">{{ __('Book picture') }}</label>           
	                    <div class="custom-file form-control">
	                        <input type="file" class="custom-file-input" id="book-image" name="new_image">
	                        <label class="custom-file-label" for="customFile">Choose file</label>
	                    </div>
					</div>
					<div class="form-group">
						<label>Category:</label>
						<select class="form-control" name="new_category">
							{{-- <option value="1">asdsad</option> --}}
							@foreach($collection['categories'] as $category)
							<option class="update-book-categories" value="{{$category->id}}">{{$category->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Author:</label>
						<select class="form-control" name="new_author">
							@foreach($collection['authors'] as $author)
							<option class="update-book-authors" value="{{$author->id}}">{{$author->name}}</option>
							@endforeach
						</select>
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

{{-- add categories modal --}}
<div id="add-category" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Category</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="/addCategory" method="POST">
					@csrf
					<div class="form-group">
						<label>Category name:</label>
						<input class="form-control" type="text" name="category">
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

{{-- update categories modal --}}
<div id="update-category" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Category</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="/updateCategory" method="POST">
					@csrf
					{{ method_field("PATCH") }}
					<input id="update-category-id" type="number" name="category_id" hidden>
					<div class="form-group">
						<label>Category name:</label>
						<input id="update-category-name" class="form-control" type="text" name="category">
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

{{-- delete category modal --}}
<div id="delete-category" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Status</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<p class="lead">Are You sure you want to delete <span id="delete-category-name"></span></p>
				<form id="delete-category-form" action="/deleteStatus" method="POST">
					@csrf
					{{ method_field("DELETE") }}
					<input id="status_delete_id" type="number" name="status_delete_id" hidden>
					<button class="btn btn-block btn-danger" type="submit">- Remove</button>
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

{{-- add authors modal --}}
<div id="add-author" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Author</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="/addAuthor" method="POST">
					@csrf
					<div class="form-group">
						<label>Author name:</label>
						<input class="form-control" type="text" name="author">
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

{{-- update authors modal --}}
<div id="update-author" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Update Author</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="/updateAuthor" method="POST">
					@csrf
					{{ method_field("PATCH") }}
					<input id="update-author-id" type="numbere" name="author_id" hidden>
					<div class="form-group">
						<label>Author name:</label>
						<input id="update-author-name" class="form-control" type="text" name="author">
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Add</button>
				</form>
			</div>
		</div>
	</div>
</div>

{{-- delete author modal --}}
<div id="delete-author" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Author</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<p class="lead">Are You sure you want to delete <span id="delete-author-name"></span></p>
				<form id="delete-author-form" action="/deleteAuthor" method="POST">
					@csrf
					{{ method_field("DELETE") }}
					<input id="status_delete_id" type="number" name="status_delete_id" hidden>
					<button class="btn btn-block btn-danger" type="submit">- Remove</button>
				</form>
			</div>
		</div>
	</div>
</div>
