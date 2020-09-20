<main role="main">

  <section class="jumbotron text-center">
    <div class="container">
      <h1>Forget Password ?</h1>
      <p class="lead text-muted">Please fill the email !</p>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row" id="notif"></div>
      <div class="row mb-5">
        <div class="col-md-12">
          <div id="notif"></div>
          <form id="form">
            <div class="form-group">
              <label for="email" class="col-form-label">Email : </label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email ..">
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-primary" id="send">Send</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</main>

<script>
  $('#send').click(function(){
      var url   = "<?=site_url('api/reset-password') ?>";
      var method  = "POST";
      var datas   = $('#form').serialize();
      
      $.ajax({
            url : url,
            type: method,
            data: datas,
            dataType: "JSON",
            success: function(data)
            {
              $("#form")[0].reset();
              $('#notif').html('<p class="alert alert-success">'+data.message+'</p>');
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $("#notif").html('<p class="alert alert-danger">'+jqXHR.responseJSON.message+'</p>');
                console.log(jqXHR.responseJSON.message);
            }
        });
  })
</script>