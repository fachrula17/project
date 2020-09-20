<main role="main">

  <section class="jumbotron text-center">
    <div class="container">
      <h1>One Step Closer Guys !</h1>
      <p class="lead text-muted">Fill this form to payment confirmation !</p>
      <p><img src="<?=base_url('assets/img/icon-bca.png') ?>" alt="" style="margin-top: -10px"> : BANK BCA a/n Fachrul Ahaddin</p>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row" id="notif"></div>
      <div class="row mb-5">
        <div class="col-md-12">
          <div id="notif"></div>
          <form id="form" enctype="multipart/form-data">
            <div class="form-group">
              <label for="fullname" class="col-form-label">Fullname : </label>
              <input type="text" class="form-control" id="fullname" name="fullname" readonly="readonly">
              <input type="hidden" class="form-control" id="id_user" name="id_user" readonly="readonly">
            </div>
            <div id="res">
              <div class="form-group">
                <label for="total" class="col-form-label">Total  : </label>
                <input type="text" class="form-control" id="total" name="total">
              </div>
              <div class="form-group">
                <label for="upload" class="col-form-label">Upload : </label>
                <input type="file" class="form-control" id="upload" name="upload">
              </div>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-primary" id="topup">Top Up</button>
            </div>
          </form>
      </div>
      <div class="row" id="result"></div>
    </div>
  </div>

</main>

<script>

  $(document).ready(function(){
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
          $('#fullname').val(data.fullname);
          $('#id_user').val(data.id_user);
          $('#total_deposit').val(data.total_deposit);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          console.log(jqXHR.responseJSON.message);
        }
    });
  })

  $('#topup').click(function(){
      
      var url   = "<?=site_url('api/topup') ?>";
      var method  = "POST";

      var datas = new FormData( $("#form")[0]);

      $.ajax({
            url : url,
            type: method,
            data: datas,
            dataType : 'JSON',
            headers: {"Authorization" : token},
            processData: false,
            contentType: false,
            success: function(data)
            {
              alert(data.message);
              window.location.href = '<?=site_url() ?>'
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $("#notif").html('<p class="alert alert-danger">'+jqXHR.responseJSON.message+'</p>');
                console.log(jqXHR.responseJSON.message);
            }
        });
  })
</script>