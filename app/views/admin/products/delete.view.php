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
              <div class="card-body mt-5">
              <?php if(isset($row)): ?>

                <p class="d-flex justify-content-center align items-center alert alert-danger">
                    Are you sure want to delete this product?
                </p>

              <form class="row g-3 m-auto p-3" method="post">
                    <div class="col-7">
                      <input type="text" name="product" readonly class="form-control" placeholder="Product Name" value="<?=old_value('product',esc($row->product))?>">
                      <div class="invalidfeedback"><?=$product->getError('product')?></div>
                    </div>

                    <div class="col-12 d-flex justify-content-center align-items-center">
                      <a href="<?=ROOT?>/dashboard/products">
                        <button class="btn btn-outline-secondary me-5" type="button">Back</button>
                      </a>
                    <button class="btn btn-outline-dark float-end" type="submit">Delete</button>
                    </div>
                  </form>
                  <?php else:?>
                    <p class="d-flex justify-content-center align items-center alert alert-light">Sorry! You Cannot Edit this Product</p>
                  <?php endif;?>
              </div>
            </div>
          </div>
        </div>
    </section>

</main>

<?php $this->view("includes/a-footer",$data) ?>