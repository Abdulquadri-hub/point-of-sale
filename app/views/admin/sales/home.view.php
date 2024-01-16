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

              <div class="row">
                <form action="" class="d-flex my-4 col-md-4">
                    <input type="text" class="form-control me-2" style="width: 400px;" type="search" placeholder="Search">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                  </form>

                  <!-- date -->
                  <form action="" method="post" class="d-flex my-2 col-md-6">

                    <div class="form-group">
                       <label class="me-2">Start Date</label>
                       <input type="date" value="<?=old_value('start')?>" name="start" class="form-control me-2" style="width: 160px;">
                    </div>

                    <div class="form-group">
                    <label  class="me-2">End Date</label>
                    <input type="date" name="end" class="form-control me-2" value="<?=old_value('end')?>" style="width: 160px;">
                    </div>

                    <div class="form-group mt-4">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    </div>
                  </form>
              </div>
                  <h5 class="card-title">All <?=$title?>
                  <a href="<?=ROOT?>">
                        <button class="btn btn-sm btn-primary float-end"><i class="bi bi-plus"></i>Add New Product</button>
                    </a>
                </h5>

                <div>
                <!-- Default Tabs -->
                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                <a href="<?=ROOT?>/dashboard/sales?tab=table">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Table view</button>
                </a>
                </li>
                <li class="nav-item" role="presentation">
                <a href="<?=ROOT?>/dashboard/sales?tab=graph">
                  <button class="nav-link" id="graph-tab" data-bs-toggle="tab" data-bs-target="#graph" type="button" role="tab" aria-controls="graph" aria-selected="false">Graph view</button>
                </a>
                </li>
                </ul>
                </div>

            <?php if($tab == "table"): ?>
                <?php $this->view("includes/sales/table",$data) ?>
                
            <?php elseif($tab == "graph"): ?>

              <?php $this->view("includes/sales/graph",$data) ?>

            <?php else: ?>
                <?php $this->view("includes/sales/table",$data) ?>
            <?php endif; ?>

              </div>
            </div>
          </div>
        </div>
    </section>

</main>


<?php $this->view("includes/a-footer",$data) ?>