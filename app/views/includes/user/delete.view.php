
<!-- Profile Edit Form -->
<form method="post">
  <div class="row mb-3">
    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label"></label>
    <div class="col-md-8 col-lg-9 my-4">
      <span class="alert alert-danger">Do you want to delete your account?</span>
      <button type="submit" class="btn btn-sm btn-outline-danger">Yes</button>
    </div>

    <div class="row mb-3">
    <label for="name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
    <div class="col-md-8 col-lg-9">
      <input  type="text" class="form-control my-2" readonly name="name" id="name" value="<?=old_value('name',esc($row->name))?>">
      <div class="invalidfeedback"><?=$user->getError('name')?></div>
    </div>
  </div>
  </div>


</form><!-- End Profile Edit Form -->
