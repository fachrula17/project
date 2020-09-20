$(function () {
	var inputFile = $('input#file');
	var uploadURI = $('#form-upload').attr('action');
	var progressBar = $('#progress-bar');
	var result = document.getElementById('result')

	/*listFilesOnServer();*/
	// listLocalStorage()

	$('#upload-btn').on('click', function(event) {
		event.preventDefault()

		var filesToUpload = inputFile[0].files;
		var product_id = $(this).data('id')

		if (filesToUpload.length > 0) {
			var formData = new FormData();

			for (var i = 0; i < filesToUpload.length; i++) {
				var file = filesToUpload[i];
				formData.append("file[]", file, file.name);				
				formData.append("product_id", product_id);				
			}

			// now upload the file using $.ajax
			$.ajax({
				url: uploadURI,
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					console.log(response)
					localStorage.setItem('images', response);

					// listLocalStorage()
					listFilesOnServer(product_id)

					setTimeout(function(){
						$('.progress').hide();
						progressBar.text("0%");
						progressBar.css({width: "0%"});
						$('.fileinput').fileinput('clear')
					}, 2000)

				},

				// sistem progress bar 
				xhr: function() {
					var xhr = new XMLHttpRequest();
					xhr.upload.addEventListener("progress", function(event) {
						if (event.lengthComputable) {
							var percentComplete = Math.round( (event.loaded / event.total) * 100 );
							
							$('.progress').show();
							progressBar.css({width: percentComplete + "%"});
							progressBar.text(percentComplete + '%');
						};
					}, false);

					return xhr;
				}
			});
		}
	});

	// hapus gambar
	$('body').on('click', '.remove-file', function () {
		var el = $(this);

		$.ajax({
			url: uploadURI,
			type: 'POST',
			data: {file_to_remove: el.attr('data-file')},
			success: function(image) {	
				console.log(image)
				var _images = JSON.parse(localStorage.getItem("images"));

				for(var i = 0; i < _images.length; i++) {
					if(_images[i].image == image) {
						_images.splice(i, 1)
						localStorage.setItem('images', JSON.stringify(_images));
					}
				}
				
				el.closest('li').remove();
			}
		});
	})

	// function listLocalStorage() {
	// 	let _images = JSON.parse(localStorage.getItem("images") ? localStorage.getItem("images") : []);
	// 	if(_images) {
	// 		_images.forEach( (el) => {
	// 			result.innerHTML += `
	// 				<li class="list-group-item">${el.image}
	// 					<a href="#" data-file="${el.image}" class="remove-file">
	// 					<i class="fas fa-trash"></i></a>
	// 				</li>`
	// 		})
	// 	}
	// }

});