<?php $this->view("includes/a-header",$data) ?>
<?php $this->view("includes/a-body-header",$data) ?>
<?php $this->view("includes/a-sidebar",$data) ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1><?=$title?></h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=ROOT?>/dashboard">Home</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item"><a href="<?=ROOT?>/dashboard/products">Products</a></li>
            <li class="breadcrumb-item active"><?=$title?></li>
          </ol>
        </nav>
    </div>
    
    
    <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
              <form class="row g-3 m-auto p-3" method="post" enctype="multipart/form-data">

                    <div class="col-4">
                      <input type="text" name="product" class="form-control" placeholder="Product Name" value="<?=old_value('product')?>">
                      <div class="invalidfeedback"><?=$product->getError('product')?></div>
                    </div>

                    <div class="col-4">
                      <input type="number"  name="price" class="form-control" placeholder="Product Price" value="<?=old_value('price')?>" step=".01">
                      <div class="invalidfeedback"><?=$product->getError("price")?></div>
                    </div>

                    <div class="col-4">
                      <input type="number" name="quantity" class="form-control" placeholder="product Quantity" value="<?=old_value('quantity')?>" id="yourEmail">
                      <div class="invalidfeedback"><?=$product->getError("quantity")?></div>
                    </div>

                    <div class="col-4">
                        <select class="form-select" name="brand_id">
                        <?php if(isset($brands) && $brands): ?>
                          <option  Selected disabled>Brands</option>
                        <?php foreach($brands as $brd): ?>
                          <option value="<?=$brd->brand_id?>"><?=$brd->brand?></option>
                        <?php endforeach; ?>
                        <?php else: ?>
                          <option  Selected disabled>No brand found!</option>
                        <?php endif; ?>
                        </select>
                        <div class="invalidfeedback"><?=$product->getError("password")?></div>
                    </div>

                    <div class="col-4">
                        <select class="form-select" name="category_id">
                        <?php if(!empty($categorys)): ?>
                          <option  Selected disabled>Category</option>
                        <?php foreach($categorys as $category): ?>
                          <option value="<?=$category->category_id?>"><?=$category->category?></option>
                        <?php endforeach; ?>
                        <?php else: ?>
                          <option  Selected disabled>No category found!</option>
                        <?php endif; ?>
                        </select>
                        <div class="invalidfeedback"><?=$product->getError("password")?></div>
                    </div>

                    <div class="col-4">
                      <label for="image" class="btn form-control text-white d-block" style="background: #012370;">Upload Image</label>
                      <input type="file"  name="image" id="image" onchange="preview_image(this.files[0])" hidden class="form-comtrol">
                      <div class="invalidfeedback"><?=$product->getError("image")?></div>
                    </div>
                    

                    <div class="col-8">
                        <textarea name="description"  class="form-control" id="" rows="6" height="100px" placeholder="Product Description"><?=old_value('description')?></textarea>
                        <div class="invalidfeedback"><?=$product->getError("description")?></div>
                    </div>

                    <div class="col-4">
                    <img src="<?=get_image()?>" class="img-thumbnail mx-auto d-block js-preview-image" height="250" alt="" style="">
                    </div>

                    <div class="col-12 d-flex justify-content-center align-items-center">
                      <a href="<?=ROOT?>/dashboard/products">
                        <button class="btn btn-outline-secondary me-5" type="button">Back</button>
                      </a>
                    <button class="btn btn-outline-dark float-end" type="submit">Save</button>
                    </div>
                  </form>
              </div>
            </div>
          </div>
        </div>
    </section>

</main>

<?php $this->view("includes/a-footer",$data) ?>

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