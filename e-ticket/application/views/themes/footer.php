<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <a href="#">Back to top</a>
    </p>
    <p>Web Application E-Ticketing For You. copyright &copy; FACHRUL AHADDIN <?=date('Y') ?></p>
  </div>
</footer>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="notif"></div>
        <form id="form">
          <div class="form-group">
            <label for="email" class="col-form-label">Email : </label>
            <input type="text" class="form-control" id="email" name="email">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Password :</label>
            <input type="password" class="form-control" id="password" name="password">
          </div>
          <p><a href="<?=site_url('home/register') ?>" title="" class="float-left">Create Account !</a></p>
          <p><a href="<?=site_url('home/forget') ?>" title="" class="float-right">Forget Password ?</a></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="login">Login</button>
          </div>
        </form>
    </div>
  </div>
</div>

<script src="<?=base_url() ?>assets/js/bootstrap.bundle.js"></script>
<script>
  var token = localStorage.getItem('member-token');

	 $('#login').click(function(){
	    event.preventDefault();
	     $.ajax({
	        url : "<?=site_url('api/member-login') ?>",
	        type: "POST",
	        data: $('#form').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {
	            localStorage.setItem("member-token", data.id_token);
	            window.location.href = "<?=site_url('home') ?>";
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            $("#notif").html('<p>'+jqXHR.responseJSON.message+'</p>');
	            console.log(jqXHR.responseJSON);
	        }
	    });
	  })

	function formatRupiah(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      rupiah        = split[0].substr(0, sisa),
      ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
 
      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
 
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function tgl_indo(string) {
      bulanIndo = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September' , 'Oktober', 'November', 'Desember'];
     
        tanggal = string.split("-")[2];
        bulan = string.split("-")[1];
        tahun = string.split("-")[0];
     
        return tanggal + " " + bulanIndo[Math.abs(bulan)] + " " + tahun;
    }
</script>
</html>