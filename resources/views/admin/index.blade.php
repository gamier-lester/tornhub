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
									<button class="edit-current-user btn" role="button" data-collection="{{$user}}">Edit Profile</button>
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
								<a href="/AuthorWorks/{{$author->id}}" role="button">View Books</a>
								<button class="update-author btn btn-block" data-id="{{$author->id}}" data-name="{{$author->name}}">Update</button>
								<button class="delete-author btn btn-block btn-danger" data-id="{{$author->id}}" data-name="{{$author->name}}">Remove</button>
							</div>
						</li>
						@endforeach
					</ul>
				</div>

			</div> <!-- end of row inside 12 column grid -->

		</div>
		<hr>
		{{-- statuses section --}}
		<!-- middle layer -->
		<div class="col-md-12">
			<div class="row">		
				<div class="col-md-4">
					<p class="lead">Manage Statuses</p>
					<button class="btn btn-outline-primary btn-block" type="button" data-toggle="modal" data-target="#add-status">Add Status</button>

					<div class="row justify-content-center">	
					@foreach(\App\Status::all() as $status)
						<div class="col-md-3 rounded m-1 text-center">
							<div class="row">
								<a href="#collapse-statuses-{{$status->id}}" data-toggle="collapse" class="list-group-item d-flex justify-content-between align-items-center d-inline col-md-12 rounded m-1 text-center">
									{{$status->name}}
								</a>
								<div id="collapse-statuses-{{$status->id}}" class="collapse col-md-12">
									<button class="update-status btn btn-block update-status" data-id="{{$status->id}}" data-name="{{$status->name}}">Update</button>
									<button class="delete-status btn btn-block btn-danger delete-status" data-id="{{$status->id}}">Remove</button>
								</div>
							</div>
						</div>
						
					@endforeach
					</div>
				</div>

				<!-- Manage Books Section -->
				<div class="col-md-4 border border-dark p-2 rounded">
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
								<div class="tab-pane book-hub <?php if($list_count === 0){ echo 'active';} ?>" id="book{{$book->id}}" role="tabpanel" style="background-image: ulr({{$book->image_path}});">
									<p class="lead">Title: {{$book->title}}</p>
									<p>Author: {{$book->authors->name}}</p>
									<p>{{$book->description}}</p>
									<button class="update-book btn" data-collection="{{$book}}">Update</button>
									<button class="delete-book btn btn-danger" data-id="{{$book->id}}" data-name="{{$book->title}}">- Remove</button>
									<?php $list_count++ ?>
								</div>
								@endforeach
							</div>
						</div>
					</div>
				</div>


				<div class="col-md-4">
					<p class="lead">Manage Categories</p>
					<button class="btn btn-outline-primary btn-block" type="button" data-toggle="modal" data-target="#add-category">Add Category</button>
					<div class="row justify-content-center">	
					@foreach(\App\Category::all() as $category)
						<div class="col-md-3 rounded m-1 text-center">
							<div class="row">
								<a href="#collapse-categories-{{$category->id}}" data-toggle="collapse" class="list-group-item d-flex justify-content-between align-items-center d-inline col-md-12 rounded m-1 text-center">
									{{$category->name}}
								</a>
								<div id="collapse-categories-{{$category->id}}" class="collapse col-md-12">
									<button class="update-category btn btn-block update-status" data-id="{{$category->id}}" data-name="{{$category->name}}">Update</button>
									<button class="delete-category btn btn-block btn-danger delete-status" data-id="{{$category->id}}">Remove</button>
								</div>
							</div>
						</div>
						
					@endforeach
					</div>
				</div>

				</div>


			</div>
		</div>
		<hr>
		<!-- lower layer -->
		<!-- Transactions section -->
		<div class="col-md-12">
			<p class="lead">Manage Transactions</p>
{{-- 			<button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#add-transaction">Add Transaction</button> --}}
			<div class="row">
				<div class="col-md-3">
					<div class="list-group">
						<a class="list-group-item list-group-item-action" href="/dashboard">All</a>
						<a class="list-group-item list-group-item-action" href="/dashboard/transactionApproved">Approved</a>
						<a class="list-group-item list-group-item-action" href="/dashboard/transactionPending">Pending</a>
						<a class="list-group-item list-group-item-action" href="/dashboard/transactionReturned">Returned</a>
					</div>
				</div>
				<div class="col-md-9">
					<table class="table table-striped">
						<thead class="thead-dark">
							<tr>
								<th>Transaction Date</th>
								<th>Email</th>
								<th>Book</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@if($collection['transactions']->count() === 0)
								<tr>
									<td scope="row" colspan="6" class="text-center"><h3>Nothing Found</h3></td>
								</tr>
							@else
							@foreach($collection['transactions'] as $transaction)
							{{-- @foreach(\App\Transaction::paginate(10) as $transaction) --}}
							<tr>
								{{-- <td>{{$transaction->id}}</td> --}}
								<td>{{$transaction->created_at->diffForHumans()}}</td>
								{{-- <td>{{dd($transaction->users)}}</td> --}}
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
								{{-- {{dd($transaction->users)}} --}}
							</tr>
							@endforeach
						</tbody>
						<tfoot>
							{{$collection['transactions']->links()}}
							{{-- {{\App\Transaction::paginate(10)->links()}} --}}
						</tfoot>
						@endif
					</table>
				</div>
			</div>

			
			
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
				<form action="/addAsset" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label>Book Title:</label>
						<input class="form-control" type="text" name="title">
					</div>
					<div class="form-group">
						<label>About: </label>
						<textarea class="form-control" name="description" rows="5"></textarea>
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
							@foreach(\App\Category::all() as $category)
							<option value="{{$category->id}}">{{$category->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Author:</label>
						<select class="form-control" name="author">
							@foreach(\App\Author::all() as $author)
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
				<form action="/updateAsset" method="POST" enctype="multipart/form-data">
					@csrf
					{{ method_field("PATCH") }}
					<input id="book_id" type="number" name="new_book_id" hidden>
					<div class="form-group">
						<label>Book Title:</label>
						<input class="form-control" type="text" name="new_title">
					</div>
					<div class="form-group">
						<label>About: </label>
						<textarea class="form-control" name="new_description" rows="5"></textarea>
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
							@foreach(\App\Category::all() as $category)
							<option class="update-book-categories" value="{{$category->id}}">{{$category->name}}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group">
						<label>Author:</label>
						<select class="form-control" name="new_author">
							@foreach(\App\Author::all() as $author)
							<option class="update-book-authors" value="{{$author->id}}">{{$author->name}}</option>
							@endforeach
						</select>
					</div>
					<button class="btn btn-block btn-success" type="submit">+ Update</button>
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

{{-- edit profile modal --}}
<div id="edit-current-profile" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="dialog">
		<div class="modal-content">
			<div class="modal-header">
				<img id="user-dp" class="img-responsive" src="" alt="No Profile Picture Added">
				<button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
			</div>
			<div class="modal-body">
				{{-- <p id="user-firstname">{{Auth::user()->username}}</p>
				<p id="user-lastname">lastname</p>
				<p id="user-email"></p>
				<p id="user-address"></p> --}}
				<form action="/admin/updateProfile" method="POST">
					@csrf
					{{method_field("PATCH")}}
					<input type="number" name="user_id" value="{{Auth::user()->id}}" hidden>
					<div class="form-group">
						<label for="user_email">Email</label>
						<input id="user_email"  class="text-center form-control" type="text" name="user_email" value="{{Auth::user()->email}}" readonly>
					</div>
					<div class="form-group">
						<label for="user_firstname">firstname</label>
						<input id="user_firstname" class="text-center form-control" type="text" name="user_firstname" value="{{Auth::user()->firstname}}">
					</div>
					<div class="form-group">
						<label for="user_lastname">lastname</label>
						<input id="user_lastname" class="text-center form-control" type="text" name="user_firstname" value="{{Auth::user()->lastname}}">
					</div>
					<div class="form-group">
						<label for="user_address">address</label>
						<input id="user_address" class="text-center form-control" type="text" name="user_address" value="{{Auth::user()->address}}">
					</div>
					<button class="form-control" type="submit" class="btn btn-success">Update My Profile</button>
				</form>

			</div>
			<div class="modal-footer">

			</div>
		</div>
	</div>
</div>

