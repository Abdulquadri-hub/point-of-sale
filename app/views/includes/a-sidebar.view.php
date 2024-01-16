  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="<?=ROOT?>/dashboard">
          <i class="bi bi-grid"></i>
          <span><?=ucfirst($ses->user('role'))?>| DASHBOARD</span>
        </a>
      </li>


      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?=ROOT?>/dashboard/products">
          <i class="bi bi-person"></i>
          <span>Products</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?=ROOT?>/dashboard/brands">
          <i class="bi bi-person"></i>
          <span>Brands</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?=ROOT?>/dashboard/category">
          <i class="bi bi-person"></i>
          <span>Category</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?=ROOT?>/dashboard/users">
          <i class="bi bi-person"></i>
          <span>Users</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?=ROOT?>/dashboard/sales">
          <i class="bi bi-person"></i>
          <span>Sales</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="<?=ROOT?>">
        <i class="bi bi-cart"></i>
          <span>Go Home</span>
        </a>
      </li>


      <?php if($ses->is_logged_in()): ?>

        <li class="nav-item">
        <a class="nav-link collapsed" href="<?=ROOT?>/logout">
          <i class="bi bi-box-arrow-right"></i>
          <span>Sign Out</span>
        </a>
      </li>       

      <?php else: ?>
        <li class="nav-item">
        <a class="nav-link collapsed" href="<?=ROOT?>/register">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="<?=ROOT?>/login">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li>
      <?php endif; ?>


      <!-- Inventory -->
      <li class="nav-heading">Inventory</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#inventory-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Stocks</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="inventory-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?=ROOT?>/dashboard/inventory/instocks">
              <i class="bi bi-circle"></i><span>In Stocks</span>
            </a>
          </li>
          <li>
            <a href="<?=ROOT?>/dashboard/inventory/outofstocks">
              <i class="bi bi-circle"></i><span>Out Of Stocks</span>
            </a>
          </li>
        </ul>
      </li>


      <!-- payments -->
      <li class="nav-heading">Payments</li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#payment-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Payments</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="payment-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?=ROOT?>/dashboard/payments/completed">
              <i class="bi bi-circle"></i><span>Completed</span>
            </a>
          </li>
          <li>
            <a href="<?=ROOT?>/dashboard/payments/pending">
              <i class="bi bi-circle"></i><span>Pending</span>
            </a>
          </li>
        </ul>
      </li>


    </ul>

  </aside><!-- End Sidebar-->