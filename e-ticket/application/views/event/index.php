<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-datepicker.min.css">
<link href="<?=base_url('assets') ?>/lightbox/css/lightbox.css" rel="stylesheet" />

<link href="<?=base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title ?></h1>
		<div class="row">
			<div class="col-sm-12">
				<div id="notif"></div>

				<div class="card mb-4">
					<div class="card-header py-3">
			            <h6 class="m-0 font-weight-bold text-primary">Add New Event Schedule</h6>
			         </div>
					<div class="card-body">

						<form id="form">
					    	<div class="form-group">
					    		<label for="event_name"><strong>Event Name</strong></label>
					    		<input type="text" class="form-control" name="event_name" id="event_name" placeholder="Event Name">
					    		<input type="hidden" class="form-control" name="id_event" id="id_event" readonly="readonly">
					    	</div>

					    	<div class="form-group">
					    		<label for="location"><strong>Location</strong></label>
					    		<input type="text" class="form-control" name="location" id="location" placeholder="Location">
					    	</div>

					    	<div class="form-group">
					    		<label for="time"><strong>Time</strong></label>
					    		<input type="time" class="form-control" name="time" id="time" placeholder="Time">
					    	</div>

					    	<div class="form-group">
					    		<label for="date"><strong>Date</strong></label>
					    		<input type="text" class="form-control datepicker" name="date" id="date" placeholder="Date">
					    	</div>

					    	<div class="form-group">
					    		<label for="price"><strong>Price</strong></label>
					    		<input type="number" class="form-control" name="price" id="price" placeholder="Price">
					    	</div>

					    	<div class="form-group">
					    		<label for="" style="margin-right: 20px; font-weight: bold">Status</label>
					    		<input type="radio" name="status" value="1"> Active
					    		<input type="radio" name="status" value="0" style="margin-left: 20px"> Not Active
					    	</div>
						    
					      	<button class="btn btn-primary" type="button" id="button">Save</button>
						</form>
					</div>
				</div>
				
				<div class="card mb-4">
					<div class="card-body">
						<div id="message"></div>
						<div class="table-responsive">
							<table class="table" id="dataTable-client">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Event Name</th>
							      <th scope="col">Location</th>
							      <th scope="col">Time</th>
							      <th scope="col">Date</th>
							      <th scope="col">Price</th>
							      <th scope="col">Status</th>
							      <th scope="col">Action</th>
							    </tr>
							  </thead>
							</table>
						</div>
					</div>
			</div>
		</div>
  </div>
  <!-- /.container-fluid -->

<!-- Page level plugins -->
<script src="<?=base_url('assets') ?>/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
// global variable
var manageClientTable;

$(document).ready(function() {
	manageClientTable = $("#dataTable-client").DataTable({
		"ajax": '<?php echo site_url('api/event')  ?>',
		'orders': []
	});	
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#image').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#imageInput").change(function() {
  readURL(this);
});
</script>


<script type="text/javascript">
  $('#button').click(function(){
  		var text = $(this).text()

  		if(text == "Save"){
  			var url 	= "<?=site_url('api/event') ?>";
  			var method	= "POST";
  			var datas 	= $('#form').serialize();
  		}else{
  			var id 		= $("#id_event").val();
  			var url 	= "<?=site_url('api/event/') ?>"+id;
  			var method	= "PUT";
  			var datas 	= {	
  				event_name : $('#event_name').val(),
  				location : $('#location').val(),
  				time : $('#time').val(),
  				date : $('#date').val(),
  				price : $('#price').val(),
  				status : $('input[type="radio"]:checked').val()
  			}
  		}

     	$.ajax({
            url : url,
            type: method,
            data: datas,
            dataType: "JSON",
            success: function(data)
            {
            	$("#form")[0].reset();
              	manageClientTable.ajax.reload(null,false);
              	$('#message').html('<p class="alert alert-success">'+data.message+'</p>');
              	alert(data.message);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $("#notif").html('<p class="alert alert-danger">'+jqXHR.responseJSON.message+'</p>');
                console.log(jqXHR.responseJSON.message);
            }
        });
  })

  function edit(id){
  		$.ajax({
            url : "<?=site_url('api/event/') ?>"+id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {	
            	$('#id_event').val(data.id_event)
            	$('#event_name').val(data.event_name)
            	$('#location').val(data.location)
            	$('#time').val(data.time)
            	$('#date').val(data.date)
            	$('#price').val(data.price)
            	$('input[type=radio][value="'+data.is_active+'"]').attr("checked", "checked");

            	$("#button").text('Update');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(jqXHR.responseJSON.message);
            }
        });
  }

  function removed(id){
  	event.preventDefault();
  	var token = localStorage.getItem("token");
  	var x = window.confirm("Are You Sure ?");
  	if(x){

  	$.ajax({
            url : "<?=site_url('api/event') ?>",
            type: "DELETE",
            data : {id : id},
            dataType: "JSON",
            headers : {"Authorization" : "Basic "+token},
            success: function(data)
            {	
            	manageClientTable.ajax.reload(null,false);
              	$('#message').html('<p class="alert alert-success">'+data.message+'</p>');
              	alert(data.message);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(jqXHR.responseJSON.message);
            }
        });
  	}
  }
</script>   

<script src="<?php echo base_url() ?>assets/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ?>assets/js/custom.js"></script>
<script>
$(document).ready(function(){
    setDatePicker()
})
</script>