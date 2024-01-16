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
            <li class="breadcrumb-item active"><?=$title?></li>
          </ol>
        </nav>
    </div>
    
    <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">

                <form action="" class="d-flex my-4">
                    <input type="text" class="form-control me-2" style="width: 400px;" type="search" placeholder="Search">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <h5 class="card-title">All <?=$title?>
                    <a href="<?=ROOT?>/dashboard/brands/add">
                        <button class="btn btn-sm btn-primary float-end"><i class="bi bi-plus"></i>Add New</button>
                    </a>
                </h5>

              <!-- message -->
              <?php if(!empty(message())): ?>
                    <div class="d-flex justify-content-center align=items-center alert alert-success">
                      <?=message('', true)?>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Brand</td>
                                <td>Created By</td>
                                <td>Date</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($brands) && $brands):?>
                            <?php foreach($brands as $key => $row):?>
                                <tr>
                                    <td><?=$key + 1?></td>
                                    <td><?=esc($row->brand)?></td>
                                    <td><?=esc(ucfirst($row->name))?></td>
                                    <td><?=get_date($row->date_created)?></td>
                                    <td class="d-flex">
                                        <a href="<?=ROOT?>/dashboard/brands/edit/<?=$row->brand_id?>">
                                            <button class="btn btn-sm btn-info me-3"><i class="bi bi-pencil"></i></button>
                                        </a>
                                        <a href="<?=ROOT?>/dashboard/brands/delete/<?=$row->brand_id?>">
                                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            <?php else:?>
                                <p class="d-flex justify-content-center align items-center alert alert-light">No Brand Found! Kindly Add a New Brand</p>
                            <?php endif;?>
                        </tbody>
                    </table>
                    <?=$pager->display()?>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>

</main>

<?php $this->view("includes/a-footer",$data) ?>