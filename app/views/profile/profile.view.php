<?php $this->view("includes/a-header",$data) ?>
<?php $this->view("includes/a-body-header",$data) ?>
<?php $this->view("includes/a-sidebar",$data) ?>

<main id="main" class="main">
  <?php if(isset($row) && $row): ?>
    
    <div class="pagetitle">
        <h1><?=$title?></h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=ROOT?>/admin">Home</a></li>
            <li class="breadcrumb-item">Pages</li>
            <li class="breadcrumb-item active"><?=$title?></li>
          </ol>
        </nav>
    </div>
    
    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="<?=get_image($row->photo)?>" alt="Profile" class="rounded-circle">

              <h2><?=ucfirst(esc($row->name))?></h2>
              <h3><?=ucfirst(esc($row->role))?></h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">

              <ul class="nav nav-tabs nav-tabs-bordered">

                <a href="<?=ROOT?>/profile/<?=$row->user_id?>">
                  <li class="nav-item">
                    <button class="nav-link active">Overview</button>
                  </li>
                </a>
  
                <a href="<?=ROOT?>/profile/edit/<?=$row->user_id?>">
                  <li class="nav-item">
                    <button class="nav-link" >Edit</button>
                  </li>
                </a>

                <a href="<?=ROOT?>/profile/delete/<?=$row->user_id?>">
                  <li class="nav-item">
                    <button class="nav-link" >Delete</button>
                  </li>
                </a>

              </ul>

              <!--  -->
              <?php
                 switch ($mode) {

                  case 'overview': 
                    $this->view("includes/user/overview",$data);
                    break;

                  case 'edit': 
                    $this->view("includes/user/edit",$data);
                    break;

                  case 'delete': 
                    $this->view("includes/user/delete",$data);
                    break;
                  
                  default:
                    # code...
                    $this->view("includes/user/overview",$data);
                    break;
                 }
              ?>
            </div>
          </div>

        </div>
      </div>
    </section>

    <?php else: ?>
        
    <div class="d-flex align-items-center">
     <div class="ps-3">
       <h4 class="alert alert-info ms-5">
        No Account found!
       </h4>
     </div>
    </div>

   <?php endif; ?>
</main>

<?php $this->view("includes/a-footer",$data) ?>