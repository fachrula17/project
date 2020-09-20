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
			            <h6 class="m-0 font-weight-bold text-primary"><?=$title ?></h6>
			         </div>
					<div class="card-body">

						<form id="form">
					    	<div class="form-group">
					    		<label for="event_name"><strong>Username</strong></label>
					    		<input type="text" class="form-control" name="username" id="username" placeholder="Username">
					    		<input type="hidden" class="form-control" name="id_admin" id="id_admin" readonly="readonly">
					    	</div>

					    	<div class="form-group">
					    		<label for="location"><strong>Password</strong></label>
					    		<input type="password" class="form-control" name="password" id="password" placeholder="">
					    	</div>

					      	<button class="btn btn-primary" type="button" id="button">Edit</button>
						</form>
					</div>
				</div>
		</div>
  </div>
  <!-- /.container-fluid -->


<script type="text/javascript">
  var token = localStorage.getItem('token');

   $.ajax({
        url : "<?=site_url('api/get-member-admin') ?>",
        type: "GET",
        dataType: "JSON",
        headers: {"Authorization" : token},
        success: function(data)
        {
          console.log(data)
          $("#username").val(data.username);
          $("#id_admin").val(data.id_admin);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          console.log(jqXHR.responseJSON.message);
        }
    });

  $("#button").click(function(){
      var url     = "<?=site_url('api/change-password/') ?>" + $("#id_admin").val();
      var method  = "PUT";
      var datas   = $('#form').serialize();
      // console.log(datas);
      $.ajax({
            url : url,
            type: method,
            data: datas,
            dataType: "JSON",
            headers: {"Authorization" : token},
            success: function(data)
            {
              alert(data.message);
              location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $("#notif").html('<p class="alert alert-danger">'+jqXHR.responseJSON.message+'</p>');
                console.log(jqXHR.responseJSON.message);
            }
        });
  })
</script>