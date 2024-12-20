@extends('layout.app')
<?php $breadCrumb='Banks / <span class="text-primary">create</span></i>'?>
@section('title', 'create bank')
@section('content')
<div class="content-wrapper">

        <!-- Content -->
        
    <div class="container-xxl flex-grow-1 container-p-y">


      <div class="row">
      <!-- FormValidation -->
      <div class="col-12">
        <div class="card">
          <div class="card-body">

            <form id="bankform" class="row g-6" onSubmit="return false">
              <div class="col-12">
                <h6>1. Account Details</h6>
                <hr class="mt-0" />
              </div>
              <div class="col-md-4">
                <label class="form-label" for="bank">Bank Name</label>
                <input type="text" id="bank" class="form-control" tag="Bank name" name="bank" />
              </div>
              <div class="col-md-4">
                <label class="form-label" for="branch">Branch</label>
                <input type="text" id="branch" class="form-control" tag="branch" name="branch" />
              </div>
              <div class="col-md-4">
                <label class="form-label" for="account-holder">Account Holder</label>
                <input type="text" id="account-holder" class="form-control" tag="account-holder" name="account_holder" />
              </div>
              <div class="col-md-4">
                <label class="form-label" for="account-no">Account No</label>
                <input type="text" id="account-no" class="form-control" tag="123123-123123-123" name="account_no" />
              </div>
              <div class="col-md-4">
                <label class="form-label" for="initial-balance">Initial Balance</label>
                <input type="number" id="initial-balance" class="form-control" tag="0000000000" name="initial_balance" />
              </div>

              <div class="col-12">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="formValidationCheckbox" name="status" />
                  <label class="form-check-label" for="formValidationCheckbox">Status</label>
                </div>
              </div>
              <div class="col-12">
                <button type="submit" id="add-btn" name="submitButton" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      </div>

    </div>
    @endsection
    @section('files')
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="../../assets/vendor/js/menu.js"></script>
    <script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>
    <!-- Page JS -->
    <script src="../../assets/js/extended-ui-sweetalert2.js"></script>
    <script src="../../assets/js/app-add-bank.js"></script>
      @endsection 
