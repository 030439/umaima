<?php $page="one";?>
@extends('layout.app')

@section('title', 'Home Page')
@section('content')

<!-- Content wrapper -->
<div class="content-wrapper">
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
  </div>
@endsection
@section('files')
<!-- Page JS -->
<script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
      <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>
    
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

<script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
<script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
<script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>

    <!-- Main JS -->
   <script src="../../assets/js/main.js"></script>
  <script src="../../assets/js/app-access-roles.js"></script>
  <script src="../../assets/js/modal-add-role.js"></script>
  <script>
  // Get references to the elements
  const menuInnerShadow = document.querySelector('.menu-inner-shadow');
  const menuInner = document.querySelector('.menu-inner');

  // Listen to the scroll event
  window.addEventListener('scroll', function() {
    // Check if the page is scrolling
    if (window.scrollY > 0) {
      // Change the class of the shadow and menu when scrolling
      menuInnerShadow.style.display = 'block';
      menuInner.classList.add('ps--scrolling-y');
    } else {
      // Revert the class changes when the scroll stops (top of the page)
      menuInnerShadow.style.display = 'none';
      menuInner.classList.remove('ps--scrolling-y');
    }
  });
</script>

@endsection