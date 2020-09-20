<main role="main">

  <section class="jumbotron text-center">
    <div class="container">
      <h1>Our Event This Year</h1>
      <p class="lead text-muted">These are our event this year. Join With Us !</p>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row" id="notif"></div>
      <div class="row mb-5">
        <div class="col-md-12">
          <form id="form">
            <div class="form-group">
              <label for="email" class="col-form-label">Email : </label>
              <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Password :</label>
              <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="form-group">
              <label for="email" class="col-form-label">Fullname : </label>
              <input type="text" class="form-control" id="fullname" name="fullname">
            </div>
            <div class="form-group">
              <label for="address" class="col-form-label">Address : </label>
              <textarea class="form-control" id="address" name="address"></textarea>
            </div>
            <div class="form-group">
              <label for="phone" class="col-form-label">Phone : </label>
              <input type="text" class="form-control" id="phone" name="phone">
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-primary" id="register">Register</button>
            </div>
          </form>
      </div>
      <div class="row" id="result"></div>
    </div>
  </div>

</main>

<script>
  $('#register').click(function(){
      
      var url   = "<?=site_url('api/member') ?>";
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
                $("#notif").html('<p class="alert alert-danger">All Field is required</p>');
                console.log(jqXHR.responseJSON.message);
            }
        });
  })
</script>