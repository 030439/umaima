<?php $page="one";?>
@extends('layout.app')

@section('title', 'Home Page')
@section('content')
<!-- / Menu -->

    

    <!-- Layout container -->
    <div class="layout-page">
      
      
    

<!-- Navbar -->

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  

  

  

      
      

      
      
      <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0   d-xl-none ">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
          <i class="ti ti-menu-2 ti-md"></i>
        </a>
      </div>
      

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        
        <!-- Search -->
        <div class="navbar-nav align-items-center">
          <div class="nav-item navbar-search-wrapper mb-0">
            <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
              <i class="ti ti-search ti-md me-2 me-lg-4 ti-lg"></i>
              <span class="d-none d-md-inline-block text-muted fw-normal">Search (Ctrl+/)</span>
            </a>
          </div>
        </div>
        <!-- /Search -->
        
        

        

        <ul class="navbar-nav flex-row align-items-center ms-auto">
          
          
          <!-- Language -->
          <li class="nav-item dropdown-language dropdown">
            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <i class='ti ti-language rounded-circle ti-md'></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="javascript:void(0);" data-language="en" data-text-direction="ltr">
                  <span>English</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);" data-language="fr" data-text-direction="ltr">
                  <span>French</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);" data-language="ar" data-text-direction="rtl">
                  <span>Arabic</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);" data-language="de" data-text-direction="ltr">
                  <span>German</span>
                </a>
              </li>
            </ul>
          </li>
          <!--/ Language -->
          
          <!-- Style Switcher -->
          <li class="nav-item dropdown-style-switcher dropdown">
            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
              <i class='ti ti-md'></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
              <li>
                <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                  <span class="align-middle"><i class='ti ti-sun ti-md me-3'></i>Light</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                  <span class="align-middle"><i class="ti ti-moon-stars ti-md me-3"></i>Dark</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                  <span class="align-middle"><i class="ti ti-device-desktop-analytics ti-md me-3"></i>System</span>
                </a>
              </li>
            </ul>
          </li>
          <!-- / Style Switcher-->
          
          <!-- Quick links  -->
          <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown">
            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill btn-icon dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <i class='ti ti-layout-grid-add ti-md'></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end p-0">
              <div class="dropdown-menu-header border-bottom">
                <div class="dropdown-header d-flex align-items-center py-3">
                  <h6 class="mb-0 me-auto">Shortcuts</h6>
                  <a href="javascript:void(0)" class="btn btn-text-secondary rounded-pill btn-icon dropdown-shortcuts-add" data-bs-toggle="tooltip" data-bs-placement="top" title="Add shortcuts"><i class="ti ti-plus text-heading"></i></a>
                </div>
              </div>
              <div class="dropdown-shortcuts-list scrollable-container">
                <div class="row row-bordered overflow-visible g-0">
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ti ti-calendar ti-26px text-heading"></i>
                    </span>
                    <a href="app-calendar.html" class="stretched-link">Calendar</a>
                    <small>Appointments</small>
                  </div>
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ti ti-file-dollar ti-26px text-heading"></i>
                    </span>
                    <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                    <small>Manage Accounts</small>
                  </div>
                </div>
                <div class="row row-bordered overflow-visible g-0">
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ti ti-user ti-26px text-heading"></i>
                    </span>
                    <a href="app-user-list.html" class="stretched-link">User App</a>
                    <small>Manage Users</small>
                  </div>
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ti ti-users ti-26px text-heading"></i>
                    </span>
                    <a href="app-access-roles.html" class="stretched-link">Role Management</a>
                    <small>Permission</small>
                  </div>
                </div>
                <div class="row row-bordered overflow-visible g-0">
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ti ti-device-desktop-analytics ti-26px text-heading"></i>
                    </span>
                    <a href="index.html" class="stretched-link">Dashboard</a>
                    <small>User Dashboard</small>
                  </div>
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ti ti-settings ti-26px text-heading"></i>
                    </span>
                    <a href="pages-account-settings-account.html" class="stretched-link">Setting</a>
                    <small>Account Settings</small>
                  </div>
                </div>
                <div class="row row-bordered overflow-visible g-0">
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ti ti-help ti-26px text-heading"></i>
                    </span>
                    <a href="pages-faq.html" class="stretched-link">FAQs</a>
                    <small>FAQs & Articles</small>
                  </div>
                  <div class="dropdown-shortcuts-item col">
                    <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                      <i class="ti ti-square ti-26px text-heading"></i>
                    </span>
                    <a href="modal-examples.html" class="stretched-link">Modals</a>
                    <small>Useful Popups</small>
                  </div>
                </div>
              </div>
            </div>
          </li>
          <!-- Quick links -->

          <!-- Notification -->
          <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
            <a class="nav-link btn btn-text-secondary btn-icon rounded-pill dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
              <span class="position-relative">
                <i class="ti ti-bell ti-md"></i>
                <span class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-0">
              <li class="dropdown-menu-header border-bottom">
                <div class="dropdown-header d-flex align-items-center py-3">
                  <h6 class="mb-0 me-auto">Notification</h6>
                  <div class="d-flex align-items-center h6 mb-0">
                    <span class="badge bg-label-primary me-2">8 New</span>
                    <a href="javascript:void(0)" class="btn btn-text-secondary rounded-pill btn-icon dropdown-notifications-all" data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i class="ti ti-mail-opened text-heading"></i></a>
                  </div>
                </div>
              </li>
              <li class="dropdown-notifications-list scrollable-container">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <img src="../../assets/img/avatars/1.png" alt class="rounded-circle">
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="small mb-1">Congratulation Lettie 🎉</h6>
                        <small class="mb-1 d-block text-body">Won the monthly best seller gold badge</small>
                        <small class="text-muted">1h ago</small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <span class="avatar-initial rounded-circle bg-label-danger">CF</span>
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1 small">Charles Franklin</h6>
                        <small class="mb-1 d-block text-body">Accepted your connection</small>
                        <small class="text-muted">12hr ago</small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <img src="../../assets/img/avatars/2.png" alt class="rounded-circle">
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1 small">New Message ✉️</h6>
                        <small class="mb-1 d-block text-body">You have new message from Natalie</small>
                        <small class="text-muted">1h ago</small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <span class="avatar-initial rounded-circle bg-label-success"><i class="ti ti-shopping-cart"></i></span>
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1 small">Whoo! You have new order 🛒 </h6>
                        <small class="mb-1 d-block text-body">ACME Inc. made new order $1,154</small>
                        <small class="text-muted">1 day ago</small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <img src="../../assets/img/avatars/9.png" alt class="rounded-circle">
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1 small">Application has been approved 🚀 </h6>
                        <small class="mb-1 d-block text-body">Your ABC project application has been approved.</small>
                        <small class="text-muted">2 days ago</small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <span class="avatar-initial rounded-circle bg-label-success"><i class="ti ti-chart-pie"></i></span>
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1 small">Monthly report is generated</h6>
                        <small class="mb-1 d-block text-body">July monthly financial report is generated </small>
                        <small class="text-muted">3 days ago</small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <img src="../../assets/img/avatars/5.png" alt class="rounded-circle">
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1 small">Send connection request</h6>
                        <small class="mb-1 d-block text-body">Peter sent you connection request</small>
                        <small class="text-muted">4 days ago</small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <img src="../../assets/img/avatars/6.png" alt class="rounded-circle">
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1 small">New message from Jane</h6>
                        <small class="mb-1 d-block text-body">Your have new message from Jane</small>
                        <small class="text-muted">5 days ago</small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item list-group-item-action dropdown-notifications-item marked-as-read">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <span class="avatar-initial rounded-circle bg-label-warning"><i class="ti ti-alert-triangle"></i></span>
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1 small">CPU is running high</h6>
                        <small class="mb-1 d-block text-body">CPU Utilization Percent is currently at 88.63%,</small>
                        <small class="text-muted">5 days ago</small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                      </div>
                    </div>
                  </li>
                </ul>
              </li>
              <li class="border-top">
                <div class="d-grid p-4">
                  <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                    <small class="align-middle">View all notifications</small>
                  </a>
                </div>
              </li>
            </ul>
          </li>
          <!--/ Notification -->

          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <img src="../../assets/img/avatars/1.png" alt class="rounded-circle">
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item mt-0" href="pages-account-settings-account.html">
                  <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                      <div class="avatar avatar-online">
                        <img src="../../assets/img/avatars/1.png" alt class="rounded-circle">
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <h6 class="mb-0">John Doe</h6>
                      <small class="text-muted">Admin</small>
                    </div>
                  </div>
                </a>
              </li>
              <li>
                <div class="dropdown-divider my-1 mx-n2"></div>
              </li>
              <li>
                <a class="dropdown-item" href="pages-profile-user.html">
                  <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">My Profile</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="pages-account-settings-account.html">
                  <i class="ti ti-settings me-3 ti-md"></i><span class="align-middle">Settings</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="pages-account-settings-billing.html">
                  <span class="d-flex align-items-center align-middle">
                    <i class="flex-shrink-0 ti ti-file-dollar me-3 ti-md"></i><span class="flex-grow-1 align-middle">Billing</span>
                    <span class="flex-shrink-0 badge bg-danger d-flex align-items-center justify-content-center">4</span>
                  </span>
                </a>
              </li>
              <li>
                <div class="dropdown-divider my-1 mx-n2"></div>
              </li>
              <li>
                <a class="dropdown-item" href="pages-pricing.html">
                  <i class="ti ti-currency-dollar me-3 ti-md"></i><span class="align-middle">Pricing</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="pages-faq.html">
                  <i class="ti ti-question-mark me-3 ti-md"></i><span class="align-middle">FAQ</span>
                </a>
              </li>
              <li>
                <div class="d-grid px-2 pt-2 pb-1">
                  <a class="btn btn-sm btn-danger d-flex" href="auth-login-cover.html" target="_blank">
                    <small class="align-middle">Logout</small>
                    <i class="ti ti-logout ms-2 ti-14px"></i>
                  </a>
                </div>
              </li>
            </ul>
          </li>
          <!--/ User -->
          


        </ul>
      </div>

      
      <!-- Search Small Screens -->
      <div class="navbar-search-wrapper search-input-wrapper  d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search...">
        <i class="ti ti-x search-toggler cursor-pointer"></i>
      </div>
      
      
  
</nav>

<!-- / Navbar -->

      

      <!-- Content wrapper -->
      <div class="content-wrapper">

        <!-- Content -->
        
          <div class="container-xxl flex-grow-1 container-p-y">
            
            
<h4 class="mb-1">Roles List</h4>

<p class="mb-6">A role provided access to predefined menus and features so that depending on <br> assigned role an administrator can have access to what user needs.</p>
<!-- Role cards -->
<div class="row g-6">
  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h6 class="fw-normal mb-0 text-body">Total 4 users</h6>
          <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Vinnie Mostowy" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Allen Rieske" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/12.png" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Julee Rossignol" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Kaith D'souza" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/3.png" alt="Avatar">
            </li>
          </ul>
        </div>
        <div class="d-flex justify-content-between align-items-end">
          <div class="role-heading">
            <h5 class="mb-1">Administrator</h5>
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal" class="role-edit-modal"><span>Edit Role</span></a>
          </div>
          <a href="javascript:void(0);"><i class="ti ti-copy ti-md text-heading"></i></a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h6 class="fw-normal mb-0 text-body">Total 7 users</h6>
          <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Jimmy Ressula" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/4.png" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="John Doe" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/1.png" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Kristi Lawker" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/2.png" alt="Avatar">
            </li>
            <li class="avatar">
              <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip" data-bs-placement="bottom" title="4 more">+4</span>
            </li>
          </ul>
        </div>
        <div class="d-flex justify-content-between align-items-end">
          <div class="role-heading">
            <h5 class="mb-1">Manager</h5>
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal" class="role-edit-modal"><span>Edit Role</span></a>
          </div>
          <a href="javascript:void(0);"><i class="ti ti-copy ti-md text-heading"></i></a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h6 class="fw-normal mb-0 text-body">Total 5 users</h6>
          <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Andrew Tye" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Rishi Swaat" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/9.png" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Rossie Kim" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/12.png" alt="Avatar">
            </li>
            <li class="avatar">
              <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip" data-bs-placement="bottom" title="2 more">+2</span>
            </li>
          </ul>
        </div>
        <div class="d-flex justify-content-between align-items-end">
          <div class="role-heading">
            <h5 class="mb-1">Users</h5>
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal" class="role-edit-modal"><span>Edit Role</span></a>
          </div>
          <a href="javascript:void(0);"><i class="ti ti-copy ti-md text-heading"></i></a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h6 class="fw-normal mb-0 text-body">Total 3 users</h6>
          <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Kim Karlos" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/3.png" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Katy Turner" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/9.png" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Peter Adward" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/4.png" alt="Avatar">
            </li>
            <li class="avatar">
              <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip" data-bs-placement="bottom" title="3 more">+3</span>
            </li>
          </ul>
        </div>
        <div class="d-flex justify-content-between align-items-end">
          <div class="role-heading">
            <h5 class="mb-1">Support</h5>
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal" class="role-edit-modal"><span>Edit Role</span></a>
          </div>
          <a href="javascript:void(0);"><i class="ti ti-copy ti-md text-heading"></i></a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h6 class="fw-normal mb-0 text-body">Total 2 users</h6>
          <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Kim Merchent" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/10.png" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Sam D'souza" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/13.png" alt="Avatar">
            </li>
            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" title="Nurvi Karlos" class="avatar pull-up">
              <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar">
            </li>
            <li class="avatar">
              <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip" data-bs-placement="bottom" title="7 more">+7</span>
            </li>
          </ul>
        </div>
        <div class="d-flex justify-content-between align-items-end">
          <div class="role-heading">
            <h5 class="mb-1">Restricted User</h5>
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal" class="role-edit-modal"><span>Edit Role</span></a>
          </div>
          <a href="javascript:void(0);"><i class="ti ti-copy ti-md text-heading"></i></a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card h-100">
      <div class="row h-100">
        <div class="col-sm-5">
          <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-4">
            <img src="../../assets/img/illustrations/add-new-roles.png" class="img-fluid mt-sm-4 mt-md-0" alt="add-new-roles" width="83">
          </div>
        </div>
        <div class="col-sm-7">
          <div class="card-body text-sm-end text-center ps-sm-0">
            <button data-bs-target="#addRoleModal" data-bs-toggle="modal" class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">Add New Role</button>
            <p class="mb-0"> Add new role, <br> if it doesn't exist.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    <h4 class="mt-6 mb-1">Total users with their roles</h4>
    <p class="mb-0">Find all of your company’s administrator accounts and their associate roles.</p>
  </div>
  <div class="col-12">
    <!-- Role Table -->
    <div class="card">
      <div class="card-datatable table-responsive">
        <table class="datatables-users table border-top">
          <thead>
            <tr>
              <th></th>
              <th></th>
              <th>User</th>
              <th>Role</th>
              <th>Plan</th>
              <th>Billing</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <!--/ Role Table -->
  </div>
</div>
<!--/ Role cards -->

<!-- Add Role Modal -->
<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="role-title mb-2">Add New Role</h4>
          <p>Set role permissions</p>
        </div>
        <!-- Add role form -->
        <form id="addRoleForm" class="row g-6" onsubmit="return false">
          <div class="col-12">
            <label class="form-label" for="modalRoleName">Role Name</label>
            <input type="text" id="modalRoleName" name="modalRoleName" class="form-control" placeholder="Enter a role name" tabindex="-1" />
          </div>
          <div class="col-12">
            <h5 class="mb-6">Role Permissions</h5>
            <!-- Permission table -->
            <div class="table-responsive">
              
              <table class="table table-flush-spacing" id="permissionsTable">
                
                <tbody>
                  
                </tbody>
              </table>
            </div>
            <!-- Permission table -->
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary me-3">Submit</button>
            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
        </form>
        <!--/ Add role form -->
      </div>
    </div>
  </div>
</div>
<!--/ Add Role Modal -->

<!-- / Add Role Modal -->
          </div>
          <!-- / Content -->

         
          @endsection
          