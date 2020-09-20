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
        <div class="col-md-12" id="check">
          <form id="form">
            <div class="form-group">
              <label for="fullname" class="col-form-label">Fullname : </label>
              <input type="text" class="form-control" id="fullname" name="fullname" readonly="readonly">
              <input type="hidden" class="form-control" id="id_event" name="id_event" readonly="readonly" value="<?=$this->uri->segment(2) ?>">
              <input type="hidden" class="form-control" id="id_user" name="id_user" readonly="readonly">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Metode :</label>
              <select name="metode" id="metode" class="form-control">
                <option value="transfer">Bank Transfer</option>
                <option value="deposit">Deposit</option>
              </select>
              <div class="invalid-feedback"></div>
            </div>
            <div id="res">
              <div class="form-group">
                <label for="bank_name" class="col-form-label">Bank Name : </label>
                <input type="text" class="form-control" id="bank_name" name="bank_name">
              </div>
              <div class="form-group">
                <label for="bank_account" class="col-form-label">Account Name : </label>
                <input type="text" class="form-control" id="bank_account" name="bank_account">
              </div>
              <div class="form-group">
                <label for="upload" class="col-form-label">Upload : </label>
                <input type="file" class="form-control" id="upload" name="upload">
              </div>
            </div>
            <div class="form-group">
                <label for="price" class="col-form-label">Total : </label>
                <input type="text" class="form-control" id="price" name="price" value="<?=$event->price ?>" readonly="readonly">
                <input type="hidden" class="form-control" id="total_deposit" name="total_deposit" readonly="readonly">
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
var token = localStorage.getItem('member-token');
if(token === null){
  window.location.assign("<?=site_url() ?>");
}

$(document).ready(function(){
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

    var datam = {id_user : get_id, id_event: $('#id_event').val()};

    console.log(datam)

   $.ajax({
    url : "<?=site_url('api/check-register') ?>",
    type: "POST",
    data : datam,
    dataType: "JSON",
    success: function(data)
    {
      if(data.status == true){
        $('#check').html('<p class="alert alert-success">You Have Been Registered!</p>');
      }
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
      console.log(jqXHR.responseJSON.message);
    }
  });
})

$("#metode").change(function(){
var x = $(this).val();
console.log(x);
if(x == 'deposit'){
if(parseInt($('#total_deposit').val()) < <?php  echo $event->price ?>){
$(this).addClass('is-invalid');
$(".invalid-feedback").html('Your deposit balance is insufficient! <a href="<?=site_url('deposit') ?>">click here to make a deposit!</a>');
$('#res').html(``);
}else{
var saldo = parseInt($('#total_deposit').val()) - parseInt(<?=$event->price?>);
$('#res').html(`<div class="form-group">
        <label for="bank_name" class="col-form-label">Deposit : </label>
        <input type="text" class="form-control" id="total_deposit" name="total_deposit" value="`+saldo+`" readonly="readonly">
        </div>`);
$('#register').removeAttr('disabled');
}
}else{
$('#register').attr('disabled', 'disabled');
$('#res').html(`<div class="form-group">
        <label for="bank_name" class="col-form-label">Bank Name : </label>
        <input type="text" class="form-control" id="bank_name" name="bank_name">
      </div>
      <div class="form-group">
        <label for="bank_account" class="col-form-label">Account Name : </label>
        <input type="text" class="form-control" id="bank_account" name="bank_account">
      </div>
      <div class="form-group">
        <label for="upload" class="col-form-label">Upload : </label>
        <input type="file" class="form-control" id="upload" name="upload">
      </div>`);
}
});

$('#register').click(function(){

var url     = "<?=site_url('api/order') ?>";
var method  = "POST";
var datas   = new FormData( $("#form")[0]);

$.ajax({
    url : url,
    type: method,
    data: datas,
    dataType: "JSON",
    headers: {"Authorization" : token},
    processData: false,
    contentType: false,
    success: function(data)
    {
      $('#notif').html('<p class="alert alert-success">'+data.message+'</p>');
      alert(data.message);
      window.location.href = "<?=site_url() ?>"
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        $("#notif").html('<p class="alert alert-danger">'+jqXHR.responseJSON.message+'</p>');
        console.log(jqXHR.responseJSON.message);
    }
});
})


</script>