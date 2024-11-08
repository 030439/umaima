@extends('layout.app')

@section('title', 'Home Page')
@section('content')
<div class="content-wrapper">

<!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    
    

      <!-- Users List Table -->
      <div class="card">
        <div class="card-header border-bottom">
          <h5 class="card-title mb-0">Filters</h5>
          <div class="d-flex justify-content-between align-items-center row pt-4 gap-4 gap-md-0">
            <div class="col-md-4 user_role"></div>
            <div class="col-md-4 user_plan"></div>
            <div class="col-md-4 user_status"></div>
          </div>
        </div>
        <div class="card-datatable table-responsive">
                <table class="datatables-users table">
                  <thead class="border-top">
                    <tr>
                      <th></th>
                      <th></th>
                      <th>Users</th>
                      <th>Role</th>
                      <th>Plan</th>
                      <th>Billing</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
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
                        <input type="text" id="modalEditUserFirstName" name="fname" class="form-control" placeholder="John" required>
                        <div class="fv-plugins-message-container invalid-feedbacks">Please enter your first name.</div>
                      </div>
                      
                      <div class="col-12 col-md-6">
                        <label class="form-label" for="modalEditUserLastName">Last Name</label>
                        <input type="text" id="modalEditUserLastName" name="lname" class="form-control" placeholder="Doe" required>
                        <div class="fv-plugins-message-container invalid-feedbacks">Please enter your last name.</div>
                      </div>
                      
                      <div class="col-12 col-md-6">
                        <label class="form-label" for="modalEditUserName">Username</label>
                        <input type="text" id="modalEditUserName" name="username" class="form-control" placeholder="johndoe007" required>
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
                        <input type="email" id="modalEditUserEmail" name="email" class="form-control" placeholder="example@domain.com" required>
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
    <script src="../../assets/js/app-user-list.js"></script>
@endsection
          