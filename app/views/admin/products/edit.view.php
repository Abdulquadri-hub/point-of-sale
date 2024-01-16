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
              <?php if(isset($row) &&  $row): ?>
              <form class="row g-3 m-auto p-3" method="post" enctype="multipart/form-data">
                    <div class="col-4">
                      <input type="text" name="product" class="form-control" placeholder="Product Name" value="<?=old_value('product',esc($row->product))?>">
                      <div class="invalidfeedback"><?=$product->getError('product')?></div>
                    </div>

                    <div class="col-4">
                      <input type="number" name="price" class="form-control" placeholder="Product Price" value="<?=old_value('price',$row->price)?>"step=".01">
                      <div class="invalidfeedback"><?=$product->getError("price")?></div>
                    </div>

                    <div class="col-4">
                      <input type="number" name="quantity" class="form-control" placeholder="product Quantity" value="<?=old_value('quantity',esc($row->quantity))?>">
                      <div class="invalidfeedback"><?=$product->getError("qunatity")?></div>
                    </div>


                    <div class="col-4">
                        <select class="form-select" name="category_id">
                          <option selected  value="<?=$row->category->category_id?>"><?=$row->category->category?></option>
                            <?php if(!empty($categorys)): ?>
                              <?php foreach($categorys as $category): ?>
                                <option value="<?=$category->category_id?>"><?=$category->category?></option>
                              <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="invalidfeedback"><?=$product->getError("category")?></div>
                    </div>

                    <div class="col-4">
                        <select class="form-select" name="brand_id">
                          <option selected  value="<?=$row->brand->brand_id?>"><?=$row->brand->brand?></option>
                            <?php if(isset($brands) && $brands): ?>
                              <?php foreach($brands as $brd): ?>
                                <option value="<?=$brd->brand_id?>"><?=$brd->brand?></option>
                              <?php endforeach; ?>
                            <?php endif; ?>                          
                        </select>
                        <div class="invalidfeedback"><?=$product->getError("brand")?></div>
                    </div>


                    <div class="col-4">
                      <label for="image" class="btn form-control text-white d-block" style="background: #012370;">Upload Image</label>
                      <input type="file"  name="image" id="image" onchange="preview_image(this.files[0])" hidden class="form-comtrol">
                      <div class="invalidfeedback"><?=$product->getError("image")?></div>
                    </div>
                    

                    <div class="col-8">
                        <textarea name="description"  class="form-control" id="" rows="6" height="100px" placeholder="Product Description"><?=old_value('description',$row->description)?></textarea>
                        <div class="invalidfeedback"><?=$product->getError("description")?></div>
                    </div>

                    <div class="col-4">
                    <img src="<?=get_image($row->image)?>" class="img-thumbnail mx-auto d-block js-preview-image" height="250" alt="" style="">
                    </div>


                    <div class="col-12 d-flex justify-content-center align-items-center">
                      <a href="<?=ROOT?>/dashboard/products">
                        <button class="btn btn-outline-secondary me-5" type="button">Back</button>
                      </a>
                    <button class="btn btn-outline-dark float-end" type="submit">Save</button>
                    </div>
                  </form>
                  <?php else:?>
                    <p class="d-flex justify-content-center align-items-center alert alert-light mt-3">Sorry! You Cannot Edit this Product</p>
                  <?php endif;?>
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