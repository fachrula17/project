<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?=strip_tags($title) ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?=base_url('assets') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?=base_url('assets') ?>/css/sb-admin-2.min.css" rel="stylesheet">
  <script src="<?=base_url('assets') ?>/vendor/jquery/jquery.min.js"></script>
  <style>
    body {font-family: 'Rubik', sans-serif !important; font-size: 16px !important}
    .has-error {border-color: #dc3545}
    .has-success {border-color: #28a745}
    .btn-node-border {border-radius: 0 !important}
    .fileinput .form-control {width: 30%; border-radius: 0}
  </style>
  <script type="text/javascript">
      function cek(event) {
      var token = localStorage.getItem('token');
        if(token === null){
          window.location.assign("<?=site_url('auth') ?>");
        }
      }
  </script>
</head>

<body id="page-top" onload="cek(event)">

  <!-- Page Wrapper -->
  <div id="wrapper">