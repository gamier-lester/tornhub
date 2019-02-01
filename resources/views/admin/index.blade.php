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
		<!-- upper layer -->
		<div class="col-md-12">
			<div class="row">
				<!-- Manager users section -->
				<div class="col-md-9">
					<h5>All Users</h5>
					<table class="table table-borderless table-light">
						<!-- can be table-dark -->
						<thead>
							<tr>
								<th scope="col">User ID</th>
								<th scope="col">User Email</th>
								<th scope="col">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach(\App\User::all() as $user)
							<tr>
								<th scope="row">{{$user->id}}</th>
								<td>{{$user->email}}</td>
								<td>
									@if($user->roles->name == "admin" && $user->id === Auth::user()->id)
									<button class="view-user btn" role="button" data-collection="{{$user}}">Edit Profile</button>
									@elseif($user->roles->name != "admin")
									<form action="/user/makeAdmin" method="POST" class="d-inline">
										@csrf
										{{ method_field("PATCH") }}
										<input type="number" name="user_id" value="{{$user->id}}" hidden>
										<button class="btn btn-danger" type="submit">Make Admin</button>
									</form>
									@else
									<form action="/user/removeAdmin" method="POST" class="d-inline">
										@csrf
										{{ method_field("PATCH") }}
										<input type="number" name="user_id" value="{{$user->id}}" hidden>
										<button class="btn btn-danger" type="submit">Remove Admin</button>
									</form>
									@endif
									<button class="view-user btn btn-primary" data-collection="{{$user}}">Details</button>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<!-- Manage authors section -->
				<div class="col-md-3">
					<p class="lead">All Authors</p>


					<ul class="list-group">
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<button class="btn btn-outline-primary btn-block" type="button" data-toggle="modal" data-target="#add-author">Add Author</button>
						</li>
						@foreach(\App\Author::all() as $author)
						<li class="list-group-item d-flex justify-content-between align-items-center">
							<a href="#collapse-{{$author->id}}" data-toggle="collapse"  role="button">{{$author->name}}</a>
							<span class="badge badge-primary badge-pill">{{$author->books->count()}}</span>
							<div id="collapse-{{$author->id}}" class="collapse">
								<button class="update-author btn btn-block" data-id="{{$author->id}}" data-name="{{$author->name}}">Update</button>
								<button class="delete-author btn btn-block btn-danger" data-id="{{$author->id}}" data-name="{{$author->name}}">Remove</button>
							</div>
						</li>
						@endforeach
					</ul>
				</div>

			</div> <!-- end of row inside 12 column grid -->

		</div>

		<!-- middle layer -->
		<div class="col-md-12">
			<div class="row">		
				<div class="col-md-3">
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

					<ul class="list-group">
						<li class=""></li>
					</ul>
				</div>

				<!-- Manage Books Section -->
				<div class="col-md-6">
					<p class="lead">Manage Books</p>

					<div class="row">
						<div class="col-md-4">
							<button class="btn btn-outline-primary btn-block mb-1" type="button" data-toggle="modal" data-target="#add-book">Add Book</button>
							<div id="book-list" class="list-group" role="tablist">
							<?php $list_count = 0;?>
							@foreach(\App\Book::all() as $book)
								<a class="list-group-item list-group-item-action <?php if($list_count === 0){ echo 'active';} ?>" data-toggle="list" href="#book{{$book->id}}" role="tab">{{$book->title}}</a>
								<?php $list_count++ ?>
							@endforeach
							</div>
						</div>
						<div class="col-md-8">
							<div class="tab-content" id="nav-tabContent">
								<?php $list_count = 0;?>
								@foreach(\App\Book::all() as $book)
								<div class="tab-pane <?php if($list_count === 0){ echo 'active';} ?>" id="book{{$book->id}}" role="tabpanel">
									<p>{{$book->title}}</p>
									<p>{{$book->authors->name}}</p>
									<button class="update-book" data-collection="{{$book}}">Update</button>
									<button class="delete-book" data-id="{{$book->id}}" data-name="{{$book->title}}">- Remove</button>
									<?php $list_count++ ?>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>


				<div class="col-md-3">
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


			</div>
		</div>
		
		<!-- lower layer -->
		<!-- Transactions section -->
		<div class="col-md-12">
			<p class="lead">Manage Transactions</p>
			<button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#add-transaction">Add Transaction</button>
			<ul>
			@foreach($collection['transactions'] as $transaction)
				<li><p>{{$transaction->id}}</p></li>
			@endforeach
			</ul>

			<table>
				<thead>
					<tr>
						<td>Transaction ID</td>
						<td>Email</td>
						<td>Book</td>
						<td>Status</td>
						<td>Action</td>
					</tr>
				</thead>
				<tbody>
					@foreach(\App\Transaction::all() as $transaction)
					<tr>
						<td>{{$transaction->id}}</td>
						<td>{{$transaction->users->email}}</td>
						<td>{{$transaction->books->title}}</td>
						<td>{{$transaction->statuses->name}}</td>
						<td>
							@if($transaction->statuses->name == "pending")
							<form action="/transaction/approve" method="POST">
								@csrf
								{{method_field("PATCH")}}
								<input type="number" name="transaction_id" value="{{$transaction->id}}" hidden>
								<button type="submit">Approve</button>
							</form>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

	</div> <!-- end of main row -->

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

{{-- Delete book modal --}}
<div id="delete-book" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Book</h5>
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<p class="lead">Are You sure you want to delete <span id="delete-book-name"></span></p>
				<form id="delete-book-form" action="/deleteAsset" method="POST">
					@csrf
					{{ method_field("DELETE") }}
					<input id="book-delete-id" type="number" name="book_delete_id" hidden>
					<button class="btn btn-block btn-danger" type="submit">- Remove</button>
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

{{-- view profile modal --}}
<div id="view-profile" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<img id="user-dp" class="img-responsive" src="" alt="No Profile Picture Added">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				<p id="user-firstname">firstname</p>
				<p id="user-lastname">lastname</p>
				<p id="user-email"></p>
				<p id="user-address"></p>
			</div>
			<div class="modal-footer">
				<button>Suspend User</button>
				<button>Remove User</button>
			</div>
		</div>
	</div>
</div>