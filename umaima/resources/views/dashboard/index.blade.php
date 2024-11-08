@extends('layout.app')

@section('title', 'Home Page')
@section('content')
 <!-- Content wrapper -->
 <div class="content-wrapper">

<!-- Content -->

  <div class="container-xxl flex-grow-1 container-p-y">
    
    
<div class="row g-6">

<!-- Sales last year -->
<div class="col-xxl-2 col-md-4 col-sm-6">
<div class="card h-100">
<div class="card-header pb-3">
<h5 class="card-title mb-1">Order</h5>
<p class="card-subtitle">Last week</p>
</div>
<div class="card-body">
<div id="ordersLastWeek"></div>
<div class="d-flex justify-content-between align-items-center gap-3">
  <h4 class="mb-0">124k</h4>
  <small class="text-success">+12.6%</small>
</div>
</div>
</div>
</div>

<!-- Sessions Last month -->
<div class="col-xxl-2 col-md-4 col-sm-6">
<div class="card h-100">
<div class="card-header pb-0">
<h5 class="card-title mb-1">Sales</h5>
<p class="card-subtitle">Last Year</p>
</div>
<div id="salesLastYear"></div>
<div class="card-body pt-0">
<div class="d-flex justify-content-between align-items-center mt-3 gap-3">
  <h4 class="mb-0">175k</h4>
  <small class="text-danger">-16.2%</small>
</div>
</div>
</div>
</div>

<!-- Total Profit -->
<div class="col-xxl-2 col-md-4 col-6">
<div class="card h-100">
<div class="card-body">
<div class="badge p-2 bg-label-danger mb-3 rounded"><i class="ti ti-credit-card ti-28px"></i></div>
<h5 class="card-title mb-1">Total Profit</h5>
<p class="card-subtitle ">Last week</p>
<p class="text-heading mb-3 mt-1">1.28k</p>
<div>
  <span class="badge bg-label-danger">-12.2%</span>
</div>
</div>
</div>
</div>

<!-- Total Sales -->
<div class="col-xxl-2 col-md-5 col-6">
<div class="card h-100">
<div class="card-body">
<div class="badge p-2 bg-label-success mb-3 rounded"><i class="ti ti-credit-card ti-28px"></i></div>
<h5 class="card-title mb-1">Total Sales</h5>
<p class="card-subtitle ">Last week</p>
<p class="text-heading mb-3 mt-1">24.67k</p>
<div>
  <span class="badge bg-label-success">+24.5%</span>
</div>
</div>
</div>
</div>

<!-- Revenue Growth -->
<div class="col-xxl-4 col-md-7">
<div class="card h-100">
<div class="card-body d-flex justify-content-between">
<div class="d-flex flex-column me-xl-7">
  <div class="card-title mb-auto">
    <h5 class="mb-2 text-nowrap">Revenue Growth</h5>
    <p class="mb-0">Weekly Report</p>
  </div>
  <div class="chart-statistics">
    <h3 class="card-title mb-1">$4,673</h3>
    <span class="badge bg-label-success">+15.2%</span>
  </div>
</div>
<div id="revenueGrowth"></div>
</div>
</div>
</div>

<!-- Earning Reports Tabs-->
<div class="col-xl-8 col-12">
<div class="card">
<div class="card-header d-flex justify-content-between">
<div class="card-title m-0">
  <h5 class="mb-1">Earning Reports</h5>
  <p class="card-subtitle">Yearly Earnings Overview</p>
</div>
<div class="dropdown">
  <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button" id="earningReportsTabsId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="ti ti-dots-vertical ti-md text-muted"></i>
  </button>
  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReportsTabsId">
    <a class="dropdown-item" href="javascript:void(0);">View More</a>
    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
  </div>
</div>
</div>
<div class="card-body">
<ul class="nav nav-tabs widget-nav-tabs pb-8 gap-4 mx-1 d-flex flex-nowrap" role="tablist">
  <li class="nav-item">
    <a href="javascript:void(0);" class="nav-link btn active d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-orders-id" aria-controls="navs-orders-id" aria-selected="true">
      <div class="badge bg-label-secondary rounded p-2"><i class="ti ti-shopping-cart ti-md"></i></div>
      <h6 class="tab-widget-title mb-0 mt-2">Orders</h6>
    </a>
  </li>
  <li class="nav-item">
    <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-sales-id" aria-controls="navs-sales-id" aria-selected="false">
      <div class="badge bg-label-secondary rounded p-2"><i class="ti ti-chart-bar ti-md"></i></div>
      <h6 class="tab-widget-title mb-0 mt-2"> Sales</h6>
    </a>
  </li>
  <li class="nav-item">
    <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-profit-id" aria-controls="navs-profit-id" aria-selected="false">
      <div class="badge bg-label-secondary rounded p-2"><i class="ti ti-currency-dollar ti-md"></i></div>
      <h6 class="tab-widget-title mb-0 mt-2">Profit</h6>
    </a>
  </li>
  <li class="nav-item">
    <a href="javascript:void(0);" class="nav-link btn d-flex flex-column align-items-center justify-content-center" role="tab" data-bs-toggle="tab" data-bs-target="#navs-income-id" aria-controls="navs-income-id" aria-selected="false">
      <div class="badge bg-label-secondary rounded p-2"><i class="ti ti-chart-pie-2 ti-md"></i></div>
      <h6 class="tab-widget-title mb-0 mt-2">Income</h6>
    </a>
  </li>
  <li class="nav-item">
    <a href="javascript:void(0);" class="nav-link btn d-flex align-items-center justify-content-center disabled" role="tab" data-bs-toggle="tab" aria-selected="false">
      <div class="badge bg-label-secondary rounded p-2"><i class="ti ti-plus ti-md"></i></div>
    </a>
  </li>
</ul>
<div class="tab-content p-0 ms-0 ms-sm-2">
  <div class="tab-pane fade show active" id="navs-orders-id" role="tabpanel">
    <div id="earningReportsTabsOrders"></div>
  </div>
  <div class="tab-pane fade" id="navs-sales-id" role="tabpanel">
    <div id="earningReportsTabsSales"></div>
  </div>
  <div class="tab-pane fade" id="navs-profit-id" role="tabpanel">
    <div id="earningReportsTabsProfit"></div>
  </div>
  <div class="tab-pane fade" id="navs-income-id" role="tabpanel">
    <div id="earningReportsTabsIncome"></div>
  </div>
</div>
</div>
</div>
</div>

<!-- Sales last 6 months -->
<div class="col-xl-4 col-md-6">
<div class="card h-100">
<div class="card-header d-flex justify-content-between pb-4">
<div class="card-title mb-0">
  <h5 class="mb-1">Sales</h5>
  <p class="card-subtitle">Last 6 Months</p>
</div>
<div class="dropdown">
  <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button" id="salesLastMonthMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="ti ti-dots-vertical ti-md text-muted"></i>
  </button>
  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesLastMonthMenu">
    <a class="dropdown-item" href="javascript:void(0);">View More</a>
    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
  </div>
</div>
</div>
<div class="card-body">
<div id="salesLastMonth"></div>
</div>
</div>
</div>

<!-- Sales By Country -->
<div class="col-xxl-4 col-md-6">
<div class="card h-100">
<div class="card-header d-flex justify-content-between">
<div class="card-title mb-0">
  <h5 class="mb-1">Sales by Countries</h5>
  <p class="card-subtitle">Monthly Sales Overview</p>
</div>
<div class="dropdown">
  <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button" id="salesByCountry" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="ti ti-dots-vertical ti-md text-muted"></i>
  </button>
  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountry">
    <a class="dropdown-item" href="javascript:void(0);">Download</a>
    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
    <a class="dropdown-item" href="javascript:void(0);">Share</a>
  </div>
</div>
</div>
<div class="card-body">
<ul class="p-0 m-0">
  <li class="d-flex align-items-center mb-4">
    <div class="avatar flex-shrink-0 me-4">
      <i class="fis fi fi-us rounded-circle fs-2"></i>
    </div>
    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
      <div class="me-2">
        <div class="d-flex align-items-center">
          <h6 class="mb-0 me-1">$8,567k</h6>

        </div>
        <small class="text-body">United states</small>
      </div>
      <div class="user-progress">
        <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
          <i class='ti ti-chevron-up'></i>
          25.8%
        </p>
      </div>
    </div>
  </li>
  <li class="d-flex align-items-center mb-4">
    <div class="avatar flex-shrink-0 me-4">
      <i class="fis fi fi-br rounded-circle fs-2"></i>
    </div>
    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
      <div class="me-2">
        <div class="d-flex align-items-center">
          <h6 class="mb-0 me-1">$2,415k</h6>
        </div>
        <small class="text-body">Brazil</small>
      </div>
      <div class="user-progress">
        <p class="text-danger fw-medium mb-0 d-flex align-items-center gap-1">
          <i class='ti ti-chevron-down'></i>
          6.2%
        </p>
      </div>
    </div>
  </li>
  <li class="d-flex align-items-center mb-4">
    <div class="avatar flex-shrink-0 me-4">
      <i class="fis fi fi-in rounded-circle fs-2"></i>
    </div>
    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
      <div class="me-2">
        <div class="d-flex align-items-center">
          <h6 class="mb-0 me-1">$865k</h6>
        </div>
        <small class="text-body">India</small>
      </div>
      <div class="user-progress">
        <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
          <i class='ti ti-chevron-up'></i>
          12.4%
        </p>
      </div>
    </div>
  </li>
  <li class="d-flex align-items-center mb-4">
    <div class="avatar flex-shrink-0 me-4">
      <i class="fis fi fi-au rounded-circle fs-2"></i>
    </div>
    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
      <div class="me-2">
        <div class="d-flex align-items-center">
          <h6 class="mb-0 me-1">$745k</h6>
        </div>
        <small class="text-body">Australia</small>
      </div>
      <div class="user-progress">
        <p class="text-danger fw-medium mb-0 d-flex align-items-center gap-1">
          <i class='ti ti-chevron-down'></i>
          11.9%
        </p>
      </div>
    </div>
  </li>
  <li class="d-flex align-items-center mb-4">
    <div class="avatar flex-shrink-0 me-4">
      <i class="fis fi fi-fr rounded-circle fs-2"></i>
    </div>
    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
      <div class="me-2">
        <div class="d-flex align-items-center">
          <h6 class="mb-0 me-1">$45</h6>
        </div>
        <small class="text-body">France</small>
      </div>
      <div class="user-progress">
        <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
          <i class='ti ti-chevron-up'></i>
          16.2%
        </p>
      </div>
    </div>
  </li>
  <li class="d-flex align-items-center">
    <div class="avatar flex-shrink-0 me-4">
      <i class="fis fi fi-cn rounded-circle fs-2"></i>
    </div>
    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
      <div class="me-2">
        <div class="d-flex align-items-center">
          <h6 class="mb-0 me-1">$12k</h6>
        </div>
        <small class="text-body">China</small>
      </div>
      <div class="user-progress">
        <p class="text-success fw-medium mb-0 d-flex align-items-center gap-1">
          <i class='ti ti-chevron-up'></i>
          14.8%
        </p>
      </div>
    </div>
  </li>
</ul>
</div>
</div>
</div>
<!--/ Sales By Country -->

<!-- Project Status -->
<div class="col-xxl-4 col-md-6">
<div class="card h-100">
<div class="card-header d-flex justify-content-between">
<h5 class="mb-0 card-title">Project Status</h5>
<div class="dropdown">
  <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button" id="projectStatusId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="ti ti-dots-vertical ti-md text-muted"></i>
  </button>
  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectStatusId">
    <a class="dropdown-item" href="javascript:void(0);">View More</a>
    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
  </div>
</div>
</div>
<div class="card-body">
<div class="d-flex align-items-start">
  <div class="badge rounded bg-label-warning p-2 me-3 rounded"><i class="ti ti-currency-dollar ti-lg"></i></div>
  <div class="d-flex justify-content-between w-100 gap-2 align-items-center">
    <div class="me-2">
      <h6 class="mb-0">$4,3742</h6>
      <small class="text-body">Your Earnings</small>
    </div>
    <h6 class="mb-0 text-success">+10.2%</h6>
  </div>
</div>
<div id="projectStatusChart"></div>
<div class="d-flex justify-content-between mb-4">
  <h6 class="mb-0">Donates</h6>
  <div class="d-flex">
    <p class="mb-0 me-4">$756.26</p>
    <p class="mb-0 text-danger">-139.34</p>
  </div>
</div>
<div class="d-flex justify-content-between">
  <h6 class="mb-0">Podcasts</h6>
  <div class="d-flex">
    <p class="mb-0 me-4">$2,207.03</p>
    <p class="mb-0 text-success">+576.24</p>
  </div>
</div>
</div>
</div>
</div>

<!-- Active Projects -->
<div class="col-xxl-4 col-md-6">
<div class="card h-100">
<div class="card-header d-flex justify-content-between">
<div class="card-title mb-0">
  <h5 class="mb-1">Active Project</h5>
  <p class="card-subtitle">Average 72% Completed</p>
</div>
<div class="dropdown">
  <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button" id="activeProjects" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="ti ti-dots-vertical ti-md text-muted"></i>
  </button>
  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="activeProjects">
    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
    <a class="dropdown-item" href="javascript:void(0);">Download</a>
    <a class="dropdown-item" href="javascript:void(0);">View All</a>
  </div>
</div>
</div>
<div class="card-body">
<ul class="p-0 m-0">
  <li class="mb-4 d-flex">
    <div class="d-flex w-50 align-items-center me-4">
      <img src="../../assets/img/icons/brands/laravel-logo.png" alt="laravel-logo" class="me-4" width="35" />
      <div>
        <h6 class="mb-0">Laravel</h6>
        <small class="text-body">eCommerce</small>
      </div>
    </div>
    <div class="d-flex flex-grow-1 align-items-center">
      <div class="progress w-100 me-4" style="height:8px;">
        <div class="progress-bar bg-danger" role="progressbar" style="width: 65%" aria-valuenow="54" aria-valuemin="0" aria-valuemax="100">
        </div>
      </div>
      <span class="text-muted">65%</span>
    </div>
  </li>
  <li class="mb-4 d-flex">
    <div class="d-flex w-50 align-items-center me-4">
      <img src="../../assets/img/icons/brands/figma-logo.png" alt="figma-logo" class="me-4" width="35" />
      <div>
        <h6 class="mb-0">Figma</h6>
        <small class="text-body">App UI Kit</small>
      </div>
    </div>
    <div class="d-flex flex-grow-1 align-items-center">
      <div class="progress w-100 me-4" style="height:8px;">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 86%" aria-valuenow="86" aria-valuemin="0" aria-valuemax="100">
        </div>
      </div>
      <span class="text-muted">86%</span>
    </div>
  </li>
  <li class="mb-4 d-flex">
    <div class="d-flex w-50 align-items-center me-4">
      <img src="../../assets/img/icons/brands/vue-logo.png" alt="vue-logo" class="me-4" width="35" />
      <div>
        <h6 class="mb-0">VueJs</h6>
        <small class="text-body">Calendar App</small>
      </div>
    </div>
    <div class="d-flex flex-grow-1 align-items-center">
      <div class="progress w-100 me-4" style="height:8px;">
        <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100">
        </div>
      </div>
      <span class="text-muted">90%</span>
    </div>
  </li>
  <li class="mb-4 d-flex">
    <div class="d-flex w-50 align-items-center me-4">
      <img src="../../assets/img/icons/brands/react-logo.png" alt="react-logo" class="me-4" width="35" />
      <div>
        <h6 class="mb-0">React</h6>
        <small class="text-body">Dashboard</small>
      </div>
    </div>
    <div class="d-flex flex-grow-1 align-items-center">
      <div class="progress w-100 me-4" style="height:8px;">
        <div class="progress-bar bg-info" role="progressbar" style="width: 37%" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100">
        </div>
      </div>
      <span class="text-muted">37%</span>
    </div>
  </li>
  <li class="mb-4 d-flex">
    <div class="d-flex w-50 align-items-center me-4">
      <img src="../../assets/img/icons/brands/bootstrap-logo.png" alt="bootstrap-logo" class="me-4" width="35" />
      <div>
        <h6 class="mb-0">Bootstrap</h6>
        <small class="text-body">Website</small>
      </div>
    </div>
    <div class="d-flex flex-grow-1 align-items-center">
      <div class="progress w-100 me-4" style="height:8px;">
        <div class="progress-bar bg-primary" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100">
        </div>
      </div>
      <span class="text-muted">22%</span>
    </div>
  </li>
  <li class="d-flex">
    <div class="d-flex w-50 align-items-center me-4">
      <img src="../../assets/img/icons/brands/sketch-logo.png" alt="sketch-logo" class="me-4" width="35" />
      <div>
        <h6 class="mb-0">Sketch</h6>
        <small class="text-body">Website Design</small>
      </div>
    </div>
    <div class="d-flex flex-grow-1 align-items-center">
      <div class="progress w-100 me-4" style="height:8px;">
        <div class="progress-bar bg-warning" role="progressbar" style="width: 29%" aria-valuenow="29" aria-valuemin="0" aria-valuemax="100">
        </div>
      </div>
      <span class="text-muted">29%</span>
    </div>
  </li>
</ul>
</div>
</div>
</div>
<!--/ Active Projects -->

<!-- Last Transaction -->
<div class="col-xl-6">
<div class="card h-100">
<div class="card-header d-flex justify-content-between align-items-center">
<h5 class="card-title m-0 me-2">Last Transaction</h5>
<div class="dropdown">
  <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-2 me-n1" type="button" id="teamMemberList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="ti ti-dots-vertical ti-md text-muted"></i>
  </button>
  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="teamMemberList">
    <a class="dropdown-item" href="javascript:void(0);">Download</a>
    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
    <a class="dropdown-item" href="javascript:void(0);">Share</a>
  </div>
</div>
</div>
<div class="table-responsive">
<table class="table table-borderless border-top">
  <thead class="border-bottom">
    <tr>
      <th>CARD</th>
      <th>DATE</th>
      <th>STATUS</th>
      <th>TREND</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="pt-5">
        <div class="d-flex justify-content-start align-items-center">
          <div class="me-4">
            <img src="../../assets/img/icons/payments/visa-img.png" alt="Visa" height="30">
          </div>
          <div class="d-flex flex-column">
            <p class="mb-0 text-heading">*4230</p><small class="text-body">Credit</small>
          </div>
        </div>
      </td>
      <td class="pt-5">
        <div class="d-flex flex-column">
          <p class="mb-0 text-heading">Sent</p>
          <small class="text-body text-nowrap">17 Mar 2022</small>
        </div>
      </td>
      <td class="pt-5"><span class="badge bg-label-success">Verified</span></td>
      <td class="pt-5">
        <p class="mb-0 text-heading">+$1,678</p>
      </td>
    </tr>
    <tr>
      <td>
        <div class="d-flex justify-content-start align-items-center">
          <div class="me-4">
            <img src="../../assets/img/icons/payments/master-card-img.png" alt="Visa" height="30">
          </div>
          <div class="d-flex flex-column">
            <p class="mb-0 text-heading">*5578</p><small class="text-body">Credit</small>
          </div>
        </div>
      </td>
      <td>
        <div class="d-flex flex-column">
          <p class="mb-0 text-heading">Sent</p>
          <small class="text-body text-nowrap">12 Feb 2022</small>
        </div>
      </td>
      <td><span class="badge bg-label-danger">Rejected</span></td>
      <td>
        <p class="mb-0 text-heading">-$839</p>
      </td>
    </tr>
    <tr>
      <td>
        <div class="d-flex justify-content-start align-items-center">
          <div class="me-4">
            <img src="../../assets/img/icons/payments/american-express-img.png" alt="Visa" height="30">
          </div>
          <div class="d-flex flex-column">
            <p class="mb-0 text-heading">*4567</p><small class="text-body">ATM</small>
          </div>
        </div>
      </td>
      <td>
        <div class="d-flex flex-column">
          <p class="mb-0 text-heading">Sent</p>
          <small class="text-body text-nowrap">28 Feb 2022</small>
        </div>
      </td>
      <td><span class="badge bg-label-success">Verified</span></td>
      <td>
        <p class="mb-0 text-heading">+$435</p>
      </td>
    </tr>
    <tr>
      <td>
        <div class="d-flex justify-content-start align-items-center">
          <div class="me-4">
            <img src="../../assets/img/icons/payments/visa-img.png" alt="Visa" height="30">
          </div>
          <div class="d-flex flex-column">
            <p class="mb-0 text-heading">*5699</p><small class="text-body">Credit</small>
          </div>
        </div>
      </td>
      <td>
        <div class="d-flex flex-column">
          <p class="mb-0 text-heading">Sent</p>
          <small class="text-body text-nowrap">8 Jan 2022</small>
        </div>
      </td>
      <td><span class="badge bg-label-secondary">Pending</span></td>
      <td>
        <p class="mb-0 text-heading">+$2,345</p>
      </td>
    </tr>
    <tr>
      <td>
        <div class="d-flex justify-content-start align-items-center">
          <div class="me-4">
            <img src="../../assets/img/icons/payments/visa-img.png" alt="Visa" height="30">
          </div>
          <div class="d-flex flex-column">
            <p class="mb-0 text-heading">*5699</p><small class="text-body">Credit</small>
          </div>
        </div>
      </td>
      <td>
        <div class="d-flex flex-column">
          <p class="mb-0 text-heading">Sent</p>
          <small class="text-body text-nowrap">8 Jan 2022</small>
        </div>
      </td>
      <td><span class="badge bg-label-danger">Rejected</span></td>
      <td>
        <p class="mb-0 text-heading">-$234</p>
      </td>
    </tr>
  </tbody>
</table>
</div>
</div>
</div>
<!--/ Last Transaction -->


<!--/ Activity Timeline -->
</div>

  </div>
  <!-- / Content -->

  
  

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
    <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>
    

    <!-- Page JS -->
    <script src="../../assets/js/dashboards-crm.js"></script>

@endsection
