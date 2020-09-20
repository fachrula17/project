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
					<div class="card-body">
						<div id="message"></div>
						<div class="table-responsive">
							<table class="table" id="dataTable-client">
							  <thead>
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Email</th>
							      <th scope="col">Fullname</th>
							      <th scope="col">Address</th>
							      <th scope="col">Phone</th>
							      <th scope="col">Saldo</th>
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
		"ajax": '<?php echo site_url('api/member')  ?>',
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

</script>
<script>
	function updateStatus(id, status){
		$.ajax({
	        url : "<?=site_url('api/update-status/') ?>"+id,
	        data: {status : status},
	        type: "POST",
	        dataType: "JSON",
	        success: function(data)
	        {
	          manageClientTable.ajax.reload(null,false);
	          alert("Data has been updated!");
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	          console.log(jqXHR.responseJSON.message);
	        }
    	});
	}

	function removed(ids){
		console.log(ids);
	  	var x = window.confirm("Are You Sure ?");
	  	if(x){

		  	$.ajax({
		        url : "<?=site_url('api/member') ?>",
		        type: "DELETE",
		        data : {id : ids},
		        dataType: "JSON",
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