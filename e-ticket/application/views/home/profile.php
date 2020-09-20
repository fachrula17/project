<main role="main">

  <section class="jumbotron text-center">
    <div class="container">
      <h1>My Profile</h1>
      <a href="<?=site_url('edit-profile') ?>" title="Change Password" class="btn btn-primary mt-4">Edit Profile</a>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row" id="result"></div>
    </div>
  </div>

</main>

<script>
  $(document).ready(function(){
    var token = localStorage.getItem('member-token');
      if(token === null){
          window.location.assign("<?=site_url() ?>");
      }
    var result = '';
    
    $.ajax({
        url : "<?=site_url('api/get-member') ?>",
        type: "GET",
        dataType: "JSON",
        headers: {"Authorization" : token},
        success: function(data)
        {
          console.log(data)
          $("#result").html(`
            <table class="table table-striped">
                <tr>
                  <th>Name</th>
                  <th>:</th>
                  <th>`+data.fullname+`</th>
                </tr>
                <tr>
                  <th>Email</th>
                  <th>:</th>
                  <th>`+data.email+`</th>
                </tr>
                <tr>
                  <th>Address</th>
                  <th>:</th>
                  <th>`+data.address+`</th>
                </tr>
                <tr>
                  <th>Phone</th>
                  <th>:</th>
                  <th>`+data.phone+`</th>
                </tr>
                <tr>
                  <th>Deposit</th>
                  <th>:</th>
                  <th>`+formatRupiah(data.total_deposit, '. ')+`</th>
                </tr>
            </table>
          `)
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          console.log(jqXHR.responseJSON.message);
        }
    });
  })
</script>