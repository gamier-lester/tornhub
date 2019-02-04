$(document).ready(() => {
	// alert('ready');
	$("#add-statusasd").click(() => {
		$.ajax({
				"url": "/addStatus",
				"type": "POST",
				"data": {
					'_token': "{{ csrf_token() }}",
					'name': 'test'
				},
				"success": function(data) {
					console.log(data);
				}
			});
	});

	$(document).on('click', '.update-status', event => {
		// console.log($(event.target).attr('data-id'));
		$("#status_id").val($(event.target).attr('data-id'));
		$("#update-status-name").val($(event.target).attr('data-name'));
		$("#update-status").modal("show");
	});

	$(document).on('click', '.delete-status', event => {
		// $(event.target).
		// console.log($("#delete-status-form").attr('action'));
		$("#delete-status-form").attr('action', '/deleteStatus/'+$(event.target).attr('data-id'));
		$("#delete-status").modal("show");
	});

	$(document).on('click', '.update-book', event => {
		
		// $("#update-book").modal("show");
		// console.log($(event.target).attr('data-collection'));
		// console.log($(event.target).data('collection')['title']);
		let bookId = $(event.target).data('collection')['id'];
		let currentTitle = $(event.target).data('collection')['title'];
		let currentYearPublished = $(event.target).data('collection')['year_published'];
		let currentImagePath = $(event.target).data('collection')['image_path'];
		let currentCategory = $(event.target).data('collection')['category_id'];
		let currentAuthor = $(event.target).data('collection')['author_id'];

		$('input[name=new_book_id]').val(bookId);
		$('input[name=new_title]').val(currentTitle);
		$('input[name=new_publishYear]').val(currentYearPublished);
		$('input[name=new_image]').val(currentImagePath);

		$('.update-book-categories').each(function(index) {
			// console.log($(this).attr('value'));
			// console.log(index);
			if($(this).attr('value') == currentCategory) {
				$(this).attr('selected', 'selected');
			}
		});

		$('.update-book-authors').each(function(index) {
			// console.log($(this).attr('value'));
			// console.log(index);
			if($(this).attr('value') == currentAuthor) {
				$(this).attr('selected', 'selected');
			}
		});
		// console.log('click');
		$('#update-book').modal('show');
	});

	$(document).on('click', '.delete-book', event => {
		// $(event.target).
		// console.log($("#delete-status-form").attr('action'));
		$('#delete-book-name').text($(event.target).attr('data-name'));
		$("#delete-book-form").attr('action', '/deleteAsset/'+$(event.target).attr('data-id'));
		$("#delete-book").modal("show");
	});

	$(document).on('click', '.update-category', event => {
		// console.log($(event.target).attr('data-id'));
		$("#update-category-id").val($(event.target).attr('data-id'));
		$("#update-category-name").val($(event.target).attr('data-name'));
		$("#update-category").modal("show");
	});

	$(document).on('click', '.delete-category', event => {
		// $(event.target).
		// console.log($("#delete-status-form").attr('action'));
		$('#delete-category-name').text($(event.target).attr('data-name'));
		$("#delete-category-form").attr('action', '/deleteCategory/'+$(event.target).attr('data-id'));
		$("#delete-category").modal("show");
	});

	$(document).on('click', '.update-author', event => {
		$('#update-author-id').val($(event.target).attr('data-id'));
		$('#update-author-name').val($(event.target).attr('data-name'));
		$('#update-author').modal("show");
	});

	$(document).on('click', '.delete-author', event => {
		// $(event.target).
		// console.log($("#delete-status-form").attr('action'));
		$('#delete-author-name').text($(event.target).attr('data-name'));
		$("#delete-author-form").attr('action', '/deleteAuthor/'+$(event.target).attr('data-id'));
		$("#delete-author").modal("show");
	});

	$(document).on('click', '.view-user', event => {
		// $(event.target).data('collection');
		let firstname = $(event.target).data('collection')['firstname'];
		let lastname = $(event.target).data('collection')['lastname'];
		let email = $(event.target).data('collection')['email'];
		let address = $(event.target).data('collection')['address'];
		let image_path = $(event.target).data('collection')['image_path'];

		$('#user-firstname').text(firstname);
		$('#user-lastname').text(lastname);
		$('#user-email').text(email);
		$('#user-address').text(address);
		$('#user-dp').attr('src', image_path);

		$('#view-profile').modal('show');
	});

	$(document).on('click', '.edit-current-user', event => {
		$('#edit-current-profile').modal('show');
	});

	$('#book-list a').on('click', function (e) {
		e.preventDefault();
		$(this).tab('show');
	});

});