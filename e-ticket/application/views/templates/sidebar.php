<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #1E0303">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
      <h2>E-Ticket</h2>
    </div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider">
  
  <li class="nav-item">
      <a class="nav-link pb-0" href="<?=site_url('admin') ?>">
          <i class="fas fw fa-user-tie"></i>
          <span>Dashboard</span>
      </a>
  </li>
  <li class="nav-item  ">
    <a class="nav-link pb-0" href="<?=site_url('member') ?>">
    <i class="fas fa-fw fa-address-book"></i>
    <span>Member</span>
    </a>
  </li>
  <li class="nav-item  ">
    <a class="nav-link pb-0" href="<?=site_url('event') ?>">
    <i class="fas fa-fw fa-address-book"></i>
    <span>Event</span>
    </a>
  </li>
  <li class="nav-item  ">
    <a class="nav-link pb-0" href="<?=site_url('deposit/show') ?>">
    <i class="fas fa-fw fa-address-book"></i>
    <span>Deposit Confirmation</span>
    </a>
  </li>
  <li class="nav-item  ">
    <a class="nav-link pb-0" href="<?=site_url('order/show') ?>">
    <i class="fas fa-fw fa-address-book"></i>
    <span>Order Confirmation</span>
    </a>
  </li>
  <hr class="sidebar-divider mt-3">
  
  
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar