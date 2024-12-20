@extends('layout.app')
<?php $breadCrumb='Allote / <span class="text-primary">List</span></i>'?>
@section('title', 'Allote')
@section('content')
<div class="content-wrapper">

<!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    
    

      <!-- Users List Table -->
      <div class="card">
        
        <div class="card-datatable table-responsive">
                <table class="datatables-users table dataTable no-footer dtr-column collapsed">
                 
                </table>
              </div>
              <style>
                /* Error messages hidden by default */
                .invalid-feedbacks {
                  display: none;
                  color: #ff4d4f; /* Red color for error messages */
                  font-size: 0.875em;
                }

                /* Highlight invalid fields */
                .is-invalid {
                  border-color: #ff4d4f;
                }
              </style>
              <!-- Offcanvas to add new user -->
              <div class="modal fade" id="addUser" tabindex="-1" aria-modal="true" role="dialog" data-select2-id="editUser" style="padding-left: 0px;">
                <div class="modal-dialog modal-lg modal-simple modal-edit-user" data-select2-id="90">
                  <div class="modal-content" data-select2-id="89">
                    <div class="modal-body" data-select2-id="88">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="text-center ">
                        <h4 class="mb-2">Enter User Information</h4>
                      </div>
                      <form id="editUserForm" class="row g-6 fv-plugins-bootstrap5 fv-plugins-framework" novalidate>
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserFirstName">First Name</label>
                          <input type="text" id="modalEditUserFirstName" name="fname" class="form-control" tag="John" required>
                          <div class="fv-plugins-message-container invalid-feedbacks">Please enter your first name.</div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserLastName">Last Name</label>
                          <input type="text" id="modalEditUserLastName" name="lname" class="form-control" tag="Doe" required>
                          <div class="fv-plugins-message-container invalid-feedbacks">Please enter your last name.</div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserName">Username</label>
                          <input type="text" id="modalEditUserName" name="username" class="form-control" tag="johndoe007" required>
                          <div class="fv-plugins-message-container invalid-feedbacks">Please enter a username.</div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="user-role">User Role</label>
                          <select id="user-roles" class="form-select" name="role" required>
                          </select>
                          <div class="fv-plugins-message-container invalid-feedbacks">Please select a user role.</div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalEditUserEmail">Email</label>
                          <input type="email" id="modalEditUserEmail" name="email" class="form-control" tag="example@domain.com" required>
                          <div class="fv-plugins-message-container invalid-feedbacks">Please enter a valid email.</div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                          <label class="form-label" for="modalPassword">Password</label>
                          <input type="password" id="modalPassword" name="password" class="form-control" required minlength="8">
                          <div class="fv-plugins-message-container invalid-feedbacks">Password must be at least 8 characters.</div>
                        </div>
                        
                        <div class="col-12">
                          <div class="form-check form-switch">
                            <input type="checkbox" name="status" class="form-check-input" id="editBillingAddress" checked>
                            <label for="editBillingAddress" class="switch-label">Status (Active by default)</label>
                          </div>
                        </div>
                        
                        <div class="col-12 text-center">
                          <button type="submit" class="btn btn-primary me-3">Submit</button>
                          <button type="reset" class="btn btn-label-secondary" aria-label="Close">Cancel</button>
                        </div>
                      </form>

                    </div>
                  </div>
                </div>
              </div>
            <div class="modal fade" id="addNewCCModal" tabindex="-1" aria-modal="true" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Details of Zsazsa McCleverty</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <table class="table">
                      <tbody>
                        <tr data-dt-row="14" data-dt-column="2">
                          <td>User:</td>
                          <td>
                            <div class="d-flex justify-content-start align-items-center user-name">
                              <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-4">
                                  <img src="../../assets/img/avatars/2.png" alt="Avatar" class="rounded-circle">
                                </div>
                              </div>
                              <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                  <span class="fw-medium">Zsazsa McCleverty</span>
                                </a>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr data-dt-row="14" data-dt-column="4">
                          <td>Email:</td>
                          <td>
                            <span class="text-heading"></span>
                          </td>
                        </tr>
                        <tr data-dt-row="14" data-dt-column="3">
                          <td>Role:</td>
                          <td>
                            <span class="text-truncate d-flex align-items-center text-heading">
                              <i class=" ti-md text-success me-2"></i>
                            </span>
                          </td>
                        </tr>
                        <tr data-dt-row="14" data-dt-column="5">
                          <td>Username:</td>
                          <td>Auto Debit</td>
                        </tr>
                        <tr data-dt-row="14" data-dt-column="6">
                          <td>Status:</td>
                          <td>
                            <span class="badge bg-label-success" text-capitalized="">Active</span>
                          </td>
                        </tr>
                        <tr data-dt-row="14" data-dt-column="7">
                          <td>Actions:</td>
                          <td>
                            <div class="d-flex align-items-center">
                              <a id="plot-detail"class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill delete-record">
                                <i class="ti ti-trash ti-md"></i>
                              </a>
                              <a href="app-user-view-account.html" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill">
                                <i class="ti ti-eye ti-md"></i>
                              </a>
                              <a href="javascript:;" class="btn btn-icon btn-text-secondary waves-effect waves-light rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical ti-md"></i>
                              </a>
                              <div class="dropdown-menu dropdown-menu-end m-0">
                                <a href="javascript:;" class="dropdown-item">Edit</a>
                                <a href="javascript:;" class="dropdown-item">Suspend</a>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>

            </div>

      </div>


  </div>
          
@endsection
@section('files')
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
    <script src="../../assets/vendor/libs/moment/moment.js"></script>
<script src="../../assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
<script src="../../assets/vendor/libs/select2/select2.js"></script>
<script src="../../assets/vendor/libs/%40form-validation/popular.js"></script>
<script src="../../assets/vendor/libs/%40form-validation/bootstrap5.js"></script>
<script src="../../assets/vendor/libs/%40form-validation/auto-focus.js"></script>
<script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
<script src="../../assets/vendor/libs/cleavejs/cleave-phone.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>
    

    <!-- Page JS -->
    <script src="../../assets/js/app-allote-list.js"></script>
@endsection
          