<link rel="stylesheet" href="<?php echo base_url() ?>assets/backend/css/bootstrap-datepicker.min.css">
  
<div class="container justify-content-center">
  <div class="col-lg-6 mx-auto">
            <img src="<?php echo base_url() ?>assets/backend/img/logo.png" alt="" style="width:100%">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an <strong class="text-primary">Account!</strong></h1>
              </div>
              <?php if($this->session->flashdata('message')) { ?>
              <?php echo $this->session->flashdata('message'); ?>
              <?php } ?>
              <form class="user" method="post" action="<?=site_url('auth/registration') ?>" enctype="multipart/form-data">
                <div class="form-group">
                  <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nama Lengkap" value="<?=set_value('fullname') ?>">
                  <?=form_error('fullname', '<span class="text-danger">', '</span>') ?>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="email" name="email" placeholder="Alamat Email" value="<?=set_value('email') ?>">
                  <?=form_error('email', '<span class="text-danger">', '</span>') ?>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                    <?=form_error('password1', '<span class="text-danger">', '</span>') ?>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat Password">
                  </div>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" value="<?=set_value('tempat_lahir') ?>">
                  <?=form_error('tempat_lahir', '<span class="text-danger">', '</span>') ?>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control datepicker" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir" value="<?=set_value('tgl_lahir') ?>">
                  <?=form_error('tgl_lahir', '<span class="text-danger">', '</span>') ?>
                </div>
                <div class="form-group">
                  <label for="gender" style="margin-right: 20px">Jenis Kelamin</label>
                  <input type="radio" class="" name="gender" value="L"> Laki-laki
                  <input type="radio" class="" name="gender" value="P" style="margin-left: 20px"> Perempuan
                </div>
                <div class="form-group">
                  <textarea class="form-control" id="address" name="address" placeholder="Alamat" value="<?=set_value('address') ?>"></textarea>
                  <?=form_error('address', '<span class="text-danger">', '</span>') ?>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control " id="phone" name="phone" placeholder="No. Telpon / WA" value="<?=set_value('phone') ?>">
                  <?=form_error('phone', '<span class="text-danger">', '</span>') ?>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control " id="fide_id" name="fide_id" placeholder="FIDE ID" value="<?=set_value('fide_id') ?>">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control " id="link_lichess" name="link_lichess" placeholder="Link LICHESS" value="<?=set_value('link_lichess') ?>">
                </div>
                <div class="form-group row">
                  <div class="col-md-3">
                    Pekerjaan :
                  </div>
                  <div class="col-md-9">
                    <select name="pekerjaan" id="" class="form-control">
                      <option value="siswa">Siswa</option>
                      <option value="karyawan">Karyawan</option>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" id="prestasi" name="prestasi" placeholder="Prestasi Terbaik" value="<?=set_value('prestasi') ?>" style="height: 200px"></textarea>
                  <?=form_error('prestasi', '<span class="text-danger">', '</span>') ?>
                </div>
                 <div class="form-group row">
                  <div class="col-md-3">
                    Upload Foto 4 X 6
                  </div>
                  <div class="col-md-9">
                    <input type="file" name="photo">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  Register Account
                </button>
              </form>
              <hr>
              <div class="text-center">
                <a href="<?=site_url('administrador/auth/forgot-password') ?>">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a href="<?=site_url('administrador') ?>">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
<script src="<?php echo base_url() ?>assets/backend/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url() ?>assets/backend/js/custom.js"></script>
<script>
$(document).ready(function(){
    setDatePicker()
})
</script>