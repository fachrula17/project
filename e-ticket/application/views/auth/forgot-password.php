<style>
  form.user .form-control-user, form.user .btn-user {
    border-radius: 5px
  }

  .font-16 {font-size: 16px}
</style>

<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12 col-md-9">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
            <div class="col-lg-6">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-2">Forgot <strong class="text-primary">Your Password?</strong></h1>
                  <p class="mb-4 font-16">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                </div>

                <?=$this->session->flashdata('message') ?>
                <form class="user" method="POST" action="<?=site_url('administrador/auth/forgot-password') ?>">
                  <div class="form-group">
                    <input type="text" id="email" name="email" class="form-control" id="email" placeholder="Enter Email Address...">
                    <?=form_error('email', '<span class="text-danger">', '</span>') ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">
                    Reset Password
                  </button>
                </form>
                <hr>
                <div class="text-center">
                  <a href="<?=site_url('administrador/auth/registration') ?>">Create an Account!</a>
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
</div>