

function addSubmenuModel() 
{
	$("#formSubmenu")[0].reset();
	$('.modal-title').text('Add Sub Menu');
	$('#formSubmenu').attr('action', '/menu/store')

	//remove textdanger
	$(".text-danger").remove();
	// remove form-group
	$(".form-control").removeClass('has-error').removeClass('has-success');

	$("#formSubmenu").unbind('submit').bind('submit', function() {
		var form = $(this);

		// remove the text-danger
		$(".text-danger").remove();

		$.ajax({
			url: form.attr('action'),
			type: form.attr('method'),
			data: form.serialize(), // /converting the form data into array and sending it to server
			dataType: 'json',
			success:function(response) {
				if(response.success === true) {
					$(".messages").html('<div class="alert alert-success alert-dismissible">'+
					  '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>'+
					  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
					'</div>');

					// hide the modal
					$("#ModalSubMenu").modal('hide');
					manageSubmenuTable.ajax.reload(null, false); 
				} else {
					if(response.messages instanceof Object) {
						$.each(response.messages, function(index, value) {
							var id = $("#"+index);

							id
							.removeClass('has-error')
							.removeClass('has-success')
							.addClass(value.length > 0 ? 'has-error' : 'has-success')

							id
							.closest('.form-group')
							.append(value);
						});
					} else {
						$(".messages").html('<div class="alert alert-warning alert-dismissible">'+
						  '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>'+
						  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
						'</div>');
					}
				}
			}
		});	

		return false;
	});

}

function editSubmenu(id = null) 
{
	if(id) {

		$("#formSubmenu")[0].reset();
		$('.form-control').removeClass('has-error').removeClass('has-success');
		$('.text-danger').remove();
		$('.modal-title').text('Edit Sub Menu');
		$('#formSubmenu').attr('action', '/menu/update/' +id)

		$.ajax({
			url: '/menu/getSelectedSubMenuInfo/'+id,
			type: 'POST',
			dataType: 'json',
			success:function(response) {
				$("#title").val(response.title);
				$("#menu_id").val(response.menu_id);
				$("#url").val(response.url);
				$("#icon").val(response.icon);

				$("#formSubmenu").unbind('submit').bind('submit', function() {
					var form = $(this);

					$.ajax({
						url: form.attr('action'),
						type: 'POST',
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							if(response.success === true) {
								$(".messages").html('<div class="alert alert-success alert-dismissible">'+
								  '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>'+
								  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
								'</div>');

								// hide the modal
								$("#ModalSubMenu").modal('hide');
								manageSubmenuTable.ajax.reload(null, false); 

							} else {
								$('.text-danger').remove()

								if(response.messages instanceof Object) {
									$.each(response.messages, function(index, value) {
										var id = $("#"+index);

										id
										.removeClass('has-error')
										.removeClass('has-success')
										.addClass(value.length > 0 ? 'has-error' : 'has-success')

										id
										.closest('.form-group')
										.append(value);									

									});
								} else {
									$(".messages").html('<div class="alert alert-warning alert-dismissible">'+
									  '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>'+
									  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
									'</div>');
								}
							}
						} // /succes
					}); // /ajax

					return false;
				});
				
			}
		});

	} else {
		alert('error failed');
	}
}

function removeSubmenu(id = null) 
{
	if(confirm('Are you sure delete this data?')) {
    // ajax delete data to database
    $.ajax({
      url : '/menu/remove/'+id,
      type: "POST",
      dataType: "JSON",
      success: function(response) {
        if(response.success === true) {
					$(".messages").html('<div class="alert alert-success alert-dismissible">'+
					  '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>'+
					  '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
					'</div>');

					manageSubmenuTable.ajax.reload(null, false); 
				}
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error deleting data');
      }
    });
  } else {
  	return false
  }
}