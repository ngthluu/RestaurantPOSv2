<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= PROJECT_SHORTCUT ?> | <?= isset($header_title) ? $header_title : "Dashboard" ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/fontawesome-free/css/all.min.css"); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"); ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css"); ?>">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/jqvmap/jqvmap.min.css"); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/dist/css/adminlte.min.css"); ?>">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"); ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/daterangepicker/daterangepicker.css"); ?>">
  <!-- summernote -->
  <link rel="stylesheet" href="<?= base_url("assets/adminlte/plugins/summernote/summernote-bs4.min.css"); ?>">

<style>
/* scrollbar */
::-webkit-scrollbar {
  width: 6px;
  height: 6px;
  background: #F1F1F1;
}

::-webkit-scrollbar-thumb {
  border-radius: 3px;
  background: #C0C0C0;
}
</style>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="<?= $_SESSION["cms_uavatar"] ?>" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"><?= $_SESSION["cms_uname"] ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="<?= $_SESSION["cms_uavatar"] ?>" class="img-circle elevation-2" alt="User Image">

            <p>
              <?= $_SESSION["cms_uname"] ?>
              <small><?= $_SESSION["cms_uemail"] ?></small>
            </p>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
            <a href="<?= site_url("cms/auth/signout") ?>" class="btn btn-default btn-flat float-right">Sign out</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= site_url("cms/dashboard") ?>" class="brand-link">
      <img src="<?= base_url("resources/logo.jpg"); ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?= PROJECT_NAME ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item <?= $this->uri->segment(2) == "dashboard" ? "menu-open" : "" ?>">
            <a href="<?= site_url("cms/dashboard") ?>" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <?php 
          if ($_SESSION["cms_urole"] == "admin")
            $this->load->view("cms/layout/header_menu_admin");
          else if ($_SESSION["cms_urole"] == "manager")
            $this->load->view("cms/layout/header_menu_manager");
          else if ($_SESSION["cms_urole"] == "chef")
            $this->load->view("cms/layout/header_menu_chef");
          else if ($_SESSION["cms_urole"] == "waiter")
            $this->load->view("cms/layout/header_menu_waiter");
          ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0"><?= isset($header_title) ? $header_title : "" ?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <?php 
            if (isset($breadcrumb_list)) { 
                foreach ($breadcrumb_list as $breadcrumb) { ?>
                <li class="breadcrumb-item"><a href="<?= $breadcrumb["uri"] ?>"><?= $breadcrumb["title"] ?></a></li>
            <?php }} ?>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->