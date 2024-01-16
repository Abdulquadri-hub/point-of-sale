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
            <li class="breadcrumb-item"><a href="<?=ROOT?>/dashboard/brands">Brands</a></li>
            <li class="breadcrumb-item active"><?=$title?></li>
          </ol>
        </nav>
    </div>
    
    
    <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card m-auto shadow" style="max-width:400px;">
              <div class="card-body">
                <?php if((isset($row)) && $row):?>

                    <p class="d-flex justify-content-center align-items-center alert alert-danger mt-3">Are you sure you want to trash this Brand!</p>

              <form class="row g-3 p-3" method="post">

                    <div class="col-12">
                      <input type="text" name="brand" readonly class="form-control" placeholder="Brand Name" value="<?=old_value('brand',$row->brand)?>">
                      <div class="invalidfeedback"><?=$brand->getError('brand')?></div>
                    </div>

                    <div class="col-12 d-flex justify-content-center align-items-center">
                      <a href="<?=ROOT?>/dashboard/brands">
                        <button class="btn btn-outline-secondary me-5" type="button">Back</button>
                      </a>
                    <button class="btn btn-outline-danger float-end" type="submit">Trash</button>
                    </div>
                  </form>
                  <?php else:?>
                    <p class="d-flex justify-content-center align-items-center alert alert-light">Sorry! You Cannot Delete this Brand</p>
                  <?php endif;?>
              </div>
            </div>
          </div>
        </div>
    </section>

</main>

<?php $this->view("includes/a-footer",$data) ?>