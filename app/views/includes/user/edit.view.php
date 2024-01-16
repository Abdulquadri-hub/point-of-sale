
<!-- Profile Edit Form -->
<form method="post" enctype="multipart/form-data">
  <div class="row mb-3">
    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
    <div class="col-md-8 col-lg-9">
      <label for="profileimage" >
      <img src="<?=get_image($row->photo)?>"  class="img-thubnail js-preview-image" alt="Profile" width="100">
      <input type="file" name="photo" onchange="preview_image(this.files[0])"  id="profileimage" hidden id="">
      </label>
      <div class="invalidfeedback"><?=$user->getError('photo')?></div>
    </div>
  </div>

  <div class="row mb-3">
    <label for="name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
    <div class="col-md-8 col-lg-9">
      <input  type="text" class="form-control" name="name" id="name" value="<?=old_value('name',esc($row->name))?>">
      <div class="invalidfeedback"><?=$user->getError('name')?></div>
    </div>
  </div>

  <div class="row mb-3">
    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
    <div class="col-md-8 col-lg-9">
      <input name="email" type="email" class="form-control" id="Email" value="<?=old_value('email',esc($row->email))?>">
    </div>
  </div>

  <div class="text-center">
    <button type="submit"  class="btn btn-sm btn-outline-dark">Save</button>
  </div>
</form><!-- End Profile Edit Form -->

<script type="text/javascript">

	function preview_image(file)
	{
		let allowed = ['image/jpeg', 'image/jpg', 'image/webp', 'image/png'];
		if(!allowed.includes(file.type))
		{

			alert("only supported images are: " + allowed.toString().replaceAll("image/", ""));
			return;
		}
		document.querySelector(".js-preview-image").src = URL.createObjectURL(file);

	}
</script>
