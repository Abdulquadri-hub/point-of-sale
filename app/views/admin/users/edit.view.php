
<style>
    .hide{
        display: none;
    }

    @keyframes appear{

        0%{opacity: 0;transform: translateY(-100px);}
        100%{opacity: 1;transform: translateY(0px);}
    }

</style>

<div role="close-button" onclick="hide_modal(event,'edit-user')" class="js-edit-user hide" style="animation: appear .5s ease; background-color:#00000088;height:100%;width:100%;position:fixed;left:0px;top:0px;z-index:4;">
  <div class="shadow js-edit-modal" style="background-color:white;width:500px;min-height:200px;padding:10px;margin:auto;margin-top:150px">

      <div class="d-flex justify-content-center py-4">
        <a href="index.html" class="logo d-flex align-items-center w-auto">
          <img src="assets/img/logo.png" alt="">
          <span class="d-none d-lg-block">Edit User</span>
        </a>
      </div>

      <div class="card mb-3">

<div class="card-body">

  <div class="row g-3">
      <div class="col-12">
        <input type="text" name="name" class="form-control js-edit-input" placeholder="Your Full Name" value="<?=old_value('name')?>" id="name">
        <div class="invalidfeedback"><?=(new \Model\User)->getError('name')?></div>
      </div>

      <div class="col-12">
        <input type="email" name="email" class="form-control js-edit-input" placeholder="E-mail Address" value="<?=old_value('email')?>" id="email">
        <div class="invalidfeedback"><?=(new \Model\User)->getError("email")?></div>
                    </div>


        <div class="col-12">
          <input type="text" name="username" class="form-control js-edit-input" placeholder="User Name" value="<?=old_value('username')?>" id="username">
          <div class="invalidfeedback"><?=(new \Model\User)->getError("username")?></div>
        </div>


        <div class="col-12">
        <input type="text" hidden name="id" class="form-control js-edit-input"  id="id">
        </div>

        <!-- <div class="col-12">
          <input type="password" name="password" class="form-control" placeholder="Password" value="<?=old_value('password')?>" id="password">
          <div class="invalidfeedback"><?=(new \Model\User)->getError("password")?></div>
        </div> -->

        <div class="col-md-6">
          <button role="close-button" onclick="hide_modal(event,'edit-user')" class="btn btn-outline-dark w-100" type="submit">Cancel</button>
        </div>

        <div class="col-md-6">
          <button role="close-button" onclick="edit_user(event)" class="btn btn-outline-primary w-100" type="submit">Save</button>
        </div>
  </div>


</div>
</div>
  </div>
</div>