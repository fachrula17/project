<style>
	div > ul {padding: 0; list-style-position: inside }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	  <h1 class="h3 mb-0 text-gray-800"><?=$title ?></h1>
	</div>
	
	<?php if($this->uri->segment(3) == 3 ) {
		$text = 'Lihat Harga'; 
	}else {
		$text = 'Daftar';
	} ?>
	<div class="row">
    	<?php foreach($programmes as $p) : ?>
		    <div class="col-xl-6 col-md-6 mb-4">
		      <div class="card border-left-primary shadow h-100 py-2">
		        <div class="card-body">
		          <div class="row no-gutters align-items-center">
		            <div class="col mr-2">
		              <div class="text-lg font-weight-bold text-primary text-uppercase mb-4"><?=$p->sub_name ?></div>
		              <div class="text-sm p-0"><?=$p->description ?></div>
		              <div class="h6 mb-0 font-weight-bold text-gray-800">
						<a <?php if($this->uri->segment(3) == 3 ) { ?> href="<?php echo site_url('admin/package/'.$p->id) ?>" <?php }else{ ?> href="<?=site_url('order/'.$p->id) ?>" <?php } ?> class="btn btn-primary"><?php echo $text ?></a>
		              </div>
		            </div>
		            <div class="col-auto">
		              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
		<?php endforeach; ?>
  </div>
</div>
<!-- /.container-fluid -->
