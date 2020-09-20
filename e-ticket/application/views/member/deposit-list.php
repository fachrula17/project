

<link href="<?=base_url('assets') ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Begin Page Content -->
  <div class="container mt-4">

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
							      <th scope="col">Name</th>
							      <th scope="col">Total</th>
							      <th scope="col">Date</th>
							      <th scope="col">Upload</th>
							      <th scope="col">Status</th>
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
  <script src="<?=base_url('assets') ?>/lightbox/js/lightbox.js"></script>

<script>
// global variable
var manageClientTable;
$(document).ready(function() {

	manageClientTable = $("#dataTable-client").DataTable({
		"ajax": '<?php echo site_url('api/member-deposit/'.$this->uri->segment(3))  ?>',
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

  function confirm(id){

      $.ajax({
          url : "<?=site_url('api/deposit/') ?>"+id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
              manageClientTable.ajax.reload(null,false);
              $('#notif').html('<p class="alert alert-success">'+data.message+'</p>');
              alert(data.message);
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              $("#notif").html('<p class="alert alert-danger">'+jqXHR.responseJSON.message+'</p>');
              console.log(jqXHR.responseJSON.message);
          }
      });
      
  }
  
</script>