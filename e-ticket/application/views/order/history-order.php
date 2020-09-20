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
							      <th scope="col">No. Ticket</th>
							      <th scope="col">Event</th>
                    <th scope="col">Date</th>
                    <th scope="col">Metode</th>
                    <th scope="col">Bank Name</th>
                    <th scope="col">Account Name</th>
							      <th scope="col">Total</th>
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

	manageClientTable = $("#dataTable-client").DataTable({
		"ajax": '<?php echo site_url('api/member-order/')  ?>'+get_id,
		'orders': []
	});	
});
</script>


<script type="text/javascript">

  function confirm(id){

      $.ajax({
          url : "<?=site_url('api/confirm-order/') ?>"+id,
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
            headers : {"Authorization" : token},
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