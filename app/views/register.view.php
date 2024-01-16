<?=$this->view("includes/a-header",$data)?>

<style>
	.invalidfeedback {
		color: red;
		/* height: 1em; */
	}
</style>

<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">ESHOP</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>

                  <form class="row g-3" method="post">
                    <div class="col-12">
                      <input type="text" name="name" class="form-control" placeholder="Your Full Name" value="<?=old_value('name')?>" id="yourName">
                      <div class="invalidfeedback"><?=$user->getError('name')?></div>
                    </div>


                    <div class="col-12">
                      <input type="email" name="email" class="form-control" placeholder="E-mail Address" value="<?=old_value('email')?>" id="yourEmail">
                      <div class="invalidfeedback"><?=$user->getError("email")?></div>
                    </div>


                    <div class="col-12">
                      <input type="text" name="username" class="form-control" placeholder="User Name" value="<?=old_value('username')?>" id="yourEmail">
                      <div class="invalidfeedback"><?=$user->getError("username")?></div>
                    </div>



                    <div class="col-12">
                      <input type="password" name="password" class="form-control" placeholder="Password" value="<?=old_value('password')?>" id="yourPassword">
                      <div class="invalidfeedback"><?=$user->getError("password")?></div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Create Account</button>
                    </div>


                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="<?=ROOT?>/login">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
</section>
<?=$this->view("includes/a-footer",$data)?>