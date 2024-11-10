@extends('layout.app')

@section('title', 'Home Page')
@section('content')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-xxl-4 col-xl-6 col-lg-12">
                    <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                        <h5 class="mb-1">Monthly Installments </h5>
                        </div>
                        <div class="dropdown">
                        <button class="btn btn-secondary add-new btn-primary waves-effect waves-light"  type="button" onclick="addPlotLocation()">
                                <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                    <span class="d-none d-sm-inline-block">Add Installent</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-6">
                                <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                    <div class="me-2">
                                    <h6 class="mb-0">Corner View</h6>
                                    </div>
                                </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-6 col-lg-12">
                    <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                        <h5 class="mb-1">Mid Payment Duration</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-secondary add-new btn-primary waves-effect waves-light"  type="button" onclick="addPlotSize()">
                                <span><i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                                    <span class="d-none d-sm-inline-block">Add Duration</span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-6">
                                <div class="d-flex align-items-center">
                                <div class="d-flex justify-content-between w-100 flex-wrap gap-2">
                                    <div class="me-2">
                                    <h6 class="mb-0">Social Network</h6>
                                    </div>
                                    <div class="d-flex align-items-center">
                                    <p class="mb-0">5000 Foot</p>
                                    </div>
                                </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            <!-- model for ploat location create -->
            <div class="modal fade" id="addPlotLocation" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-simple">
                    <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-6">
                        <h4 class="mb-2">Add New Installmet</h4>
                        </div>
                        <form id="addPermissionForm" class="row" onsubmit="return false">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="modalPermissionName">Installment </label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control" placeholder="installemnt">
                        </div>
                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-4">Create Installment</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
            <!-- model for create of plot size -->
            <div class="modal fade" id="addPlotSize" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-simple">
                    <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center mb-6">
                        <h4 class="mb-2">Add Mid Payment Duration</h4>
                        <p>add ploat size in number</p>
                        </div>
                        <form id="addPermissionForm" class="row" onsubmit="return false">
                        <div class="col-12 mb-4">
                            <label class="form-label" for="modalPermissionName">Payment Duration</label>
                            <input type="text" id="modalPermissionName" name="modalPermissionName" class="form-control" placeholder="Payment Duration">
                        </div>
                        <div class="col-12 text-center demo-vertical-spacing">
                            <button type="submit" class="btn btn-primary me-4">Create Plot Size</button>
                            <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
    </div>

@endsection
@section('files')
<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->

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


<script src="../../assets/vendor/libs/%40form-validation/popular.js"></script>
<script src="../../assets/vendor/libs/%40form-validation/bootstrap5.js"></script>
<script src="../../assets/vendor/libs/%40form-validation/auto-focus.js"></script>

<!-- Main JS -->
<script src="../../assets/js/main.js"></script>
<script>
     function addPlotSize() {
        const addCCModal = new bootstrap.Modal(document.getElementById('addPlotSize'));
        addCCModal.show();
    }
    function addPlotLocation() {
        const addCCModal = new bootstrap.Modal(document.getElementById('addPlotLocation'));
        addCCModal.show();
    }
</script>
    

@endsection
