<link href="<?=base_url('assets') ?>/backend/lightbox/css/lightbox.css" rel="stylesheet" />

<link href="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?=$title ?></h1>
		<div class="row">
			<div class="col-sm-12">
				
				<div class="card mb-4">
					<div class="card-body">
						<div class="table-responsive">
							<table class="table" id="dataTable-client">
							  <thead>
							    <tr>
							      <th>#</th>
							      <th>Nama</th>
							      <th>Email</th>
							      <th>Alamat</th>
							      <th>Photo</th>
							      <th>Date</th>
							      <th>Action</th>
							    </tr>
							  </thead>
							</table>
						</div>
					</div>
			</div>
		</div>
  </div>
  <!-- /.container-fluid -->

<script src="<?=base_url('assets') ?>/backend/lightbox/js/lightbox.js"></script>

	<!-- Page level plugins -->
<script src="<?=base_url('assets') ?>/backend/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url('assets') ?>/backend/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
// global variable
var manageClientTable;

$(document).ready(function() {
	manageClientTable = $("#dataTable-client").DataTable({
		"ajax": '<?php echo site_url('coaching-clinic/getList/'.$this->uri->segment(3))  ?>',
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
<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ?>assets/backend/js/custom.js"></script>
<script>
$(document).ready(function(){
    setDatePicker()
})
</script>

      