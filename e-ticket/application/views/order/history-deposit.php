  <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-datepicker.min.css">
<link href="<?=base_url('assets') ?>/lightbox/css/lightbox.css" rel="stylesheet" />

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
var token = localStorage.getItem('member-token');
if(token === null){
          window.location.assign("<?=site_url() ?>");
      }
      
$(document).ready(function() {
  
  var get_id = function () {
    var user = null;
    $.ajax({
        url : "<?=site_url('api/get-member') ?>",
        type: "GET",
        dataType: "JSON",
        async : false,
        headers: {"Authorization" : token},
        success: function(data)
        {
          user = data.id_user
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          console.log(jqXHR.responseJSON.message);
        }
    });
    return user;
  }();

  console.log(get_id);

	manageClientTable = $("#dataTable-client").DataTable({
		"ajax": '<?php echo site_url('api/member-deposit/')  ?>'+get_id,
		'orders': []
	});	
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