<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Success</title>

  <!-- Custom fonts for this template-->
  <link href="<?=base_url('assets') ?>/backend/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?=base_url('assets') ?>/backend/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid mt-5">

          <!-- 404 Error Text -->
          <div class="text-center">
            <h2 class="mx-auto">Akun Anda Sudah Aktif</h2>
            <p class="lead text-gray-800 mb-5">Terima Kasih</p>
            <!-- <p class="text-gray-500 mb-0">Account activation failed! Wrong email</p> -->
            <?=$this->session->flashdata('message') ?>
            <a href="<?php echo site_url('auth') ?>" class="btn btn-success">&larr; Back to Login</a>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Bootstrap core JavaScript-->
  <script src="<?=base_url('assets') ?>/backend/vendor/jquery/jquery.min.js"></script>
  <script src="<?=base_url('assets') ?>/backend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?=base_url('assets') ?>/backend/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?=base_url('assets') ?>/backend/js/sb-admin-2.min.js"></script>

</body>

</html>
