<main role="main">

  <section class="jumbotron text-center">
    <div class="container">
      <h1>Edit Your Profile</h1>
      <p class="lead text-muted">Setting your profile here !</p>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row" id="notif"></div>
      <div class="row mb-5">
        <div class="col-md-12 col-sm-6 col-12">
          <form id="form">
            <div class="form-group">
              <label for="email" class="col-form-label">Email : </label>
              <input type="email" class="form-control" id="emails" name="emails">
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
              <label for="message-text" class="col-form-label">Password :</label>
              <input type="password" class="form-control" id="password" name="password">
              <input type="hidden" class="form-control" id="id_user" name="id_user">
              <small id="pesswordHelp" class="form-text text-muted">Fill the password, if you want to change your password!.</small>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-primary" id="update">Update</button>
            </div>
          </form>
      </div>
      <div class="row" id="result"></div>
    </div>
  </div>

</main>

<script>
   $(document).ready(function(){
    var result = '';
    var token = localStorage.getItem('member-token');
    if(token === null){
          window.location.assign("<?=site_url() ?>");
      }
      
    $.ajax({
        url : "<?=site_url('api/get-member') ?>",
        type: "GET",
        dataType: "JSON",
        headers: {"Authorization" : token},
        success: function(data)
        {
          console.log(data)
          $("#emails").val(data.email);
          $("#fullname").val(data.fullname);
          $("#address").val(data.address);
          $("#phone").val(data.phone);
          $("#id_user").val(data.id_user);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          console.log(jqXHR.responseJSON.message);
        }
    });
  })

  $('#update').click(function(){
      
      var url     = "<?=site_url('api/member/') ?>" + $("#id_user").val();
      var method  = "PUT";
      var datas   = $('#form').serialize();

      $.ajax({
            url : url,
            type: method,
            data: datas,
            dataType: "JSON",
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