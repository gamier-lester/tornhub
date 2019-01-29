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
});