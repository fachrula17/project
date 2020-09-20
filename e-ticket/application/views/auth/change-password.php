<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-lg-6">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900">Change <strong class="text-primary">Password</strong></h1>
                  <h5 class="mb-4" id="notif"></h5>
                </div>

                <form class="user" id="form">
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Enter new password">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat Password">
                  </div>
                  <button type="button" class="btn btn-primary btn-user btn-block" id="change">
                    Change Password
                  </button>
                </form>
                <hr>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  var getUrlParameter = function getUrlParameter(sParam) {
      var sPageURL = window.location.search.substring(1),
          sURLVariables = sPageURL.split('&'),
          sParameterName,
          i;

      for (i = 0; i < sURLVariables.length; i++) {
          sParameterName = sURLVariables[i].split('=');

          if (sParameterName[0] === sParam) {
              return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
          }
      }
  };

  $('#change').click(function(){
      event.preventDefault();
      
      var url     = "<?=site_url('api/change-password') ?>";
      var method  = "POST";
      var email   = getUrlParameter('email');
      var datas   = {email: email, password1: $("#password1").val(), password2: $("#password2 ").val() };
      
      $.ajax({
            url : url,
            type: method,
            data: datas,
            dataType: "JSON",
            success: function(data)
            {
              $("#form")[0].reset();
              $('#notif').html('<p class="alert alert-success">'+data.message+', <a href="<?=site_url('home') ?>">Click This Link!</a></p>');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $("#notif").html('<p class="alert alert-danger">'+jqXHR.responseJSON.message+'</p>');
                console.log(jqXHR.responseJSON.message);
            }
        });
  })
</script>