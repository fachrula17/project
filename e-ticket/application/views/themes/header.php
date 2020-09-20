<header>
  <div class="collapse bg-dark" id="navbarHeader">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 py-1" id="main-menu">
          <ul class="list-unstyled mb-0 text-right">
            <li><a href="#" data-toggle="modal" data-target="#exampleModal" class="text-white">Login</a></li>
            <li><a href="<?=site_url('home/register') ?>" class="text-white">Register</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="navbar navbar-dark bg-dark shadow-sm">
  <div class="container d-flex justify-content-between">
    <a href="<?=site_url('home') ?>" class="navbar-brand d-flex align-items-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2" viewBox="0 0 24 24" focusable="false"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
      <strong>E-Ticketing</strong>
    </a>
    <div class="col-md-9 text-right">

      <p class="text-white mb-0" id="profile"></p>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
  </div>
</header>

<script>
$(document).ready(function(){
  var token = localStorage.getItem('member-token');
  var menu = `<ul class="list-unstyled main bg-danger mb-0"><li><a href="<?=site_url()?>" class="text-white">Home</a></li><li><a href="<?=site_url('history-order')?>" class="text-white">Order History</a></li><li><a href="<?=site_url('profile')?>" class="text-white">Profile</a></li><li><a href="<?=site_url('history-deposit')?>" class="text-white">Deposit History</a></li><li><a href="#" class="text-white" id="logout">Logout</a></li></ul>`;
   user = '';

  $.ajax({
        url : "<?=site_url('api/get-member') ?>",
        type: "GET",
        dataType: "JSON",
        headers: {"Authorization" : token},
        success: function(data)
        {
          user = data.id_user
          $("#profile").html("Hai, <a href=''>"+data.fullname+"</a></span> | Saldo : <span id='saldo'>"+formatRupiah(data.total_deposit, ". ")+"</span>");
          $("#main-menu").html(menu);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          console.log(jqXHR.responseJSON.message);
        }
    });
  })

$(document).on('click', '#logout', function(){
  event.preventDefault();
  localStorage.removeItem('member-token');
  window.location.href = "<?=site_url() ?>";
})
</script>