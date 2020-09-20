<style>
  form.user .form-control-user, form.user .btn-user {
    border-radius: 5px
  }
</style>

<div class="container mt-5">

  <!-- Outer Row -->
  <div class="row justify-content-center">
    <div class="col-lg-5">
      <img src="<?php echo base_url() ?>assets/backend/img/logo.png" alt="" style="width:100%">
      <div class="card o-hidden border-0 shadow-lg my-4">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h3 text-gray-900 mb-4">Login <strong class="text-primary">Page</strong></h1>
                </div>
                
                <div id="notif"></div>

                <form class="user" method="POST" id="form">
                  <div class="form-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username ..." value="<?=set_value('username') ?>">
                    <?=form_error('username', '<span class="text-danger">', '</span>') ?>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <?=form_error('password', '<span class="text-danger">', '</span>') ?>
                  </div>
                  <button type="button" class="btn btn-primary bg-custom btn-block">Login</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('button').click(function(){
     $.ajax({
            url : "<?=site_url('api/login') ?>",
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {
              console.log(data)
                localStorage.setItem("token", data.id_token);
                window.location.href = "<?=site_url('admin') ?>";
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $("#notif").html('<p class="alert alert-danger">'+jqXHR.responseJSON.message+'</p>');
                console.log(jqXHR.responseJSON.message);
            }
        });
  })
</script>