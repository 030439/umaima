<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  
  <div class="app-brand demo ">
    <a href="{{route('dashboard.index')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
      <img src="../../assets/img/icons/brands/laravel-logo.png" height="22" width="32">
</span>
      <span class="app-brand-text demo menu-text fw-bold">Laravel Admin</span>
    </a>

    <!-- <a href="{{route('dashboard.index')}}" class="app-brand-link">
      <span class="">
        <img src="../../assets/img/icons/brands/laravel-logo.png" height="45" width="200">
      </span>
    </a> -->

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
      <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  
  
  <ul class="menu-inner py-1">
    <!-- Dashboards -->
    <li class="menu-item">
      <a href="{{route('dashboard.index')}}" class="menu-link ">
        <i class="menu-icon tf-icons ti ti-smart-home"></i>
        <div data-i18n="Dashboards">Dashboards</div>
      </a>
    </li>


    <!-- Apps & Pages -->
    <li class="menu-header small">
      <span class="menu-header-text" >User - Accounts</span>
    </li>
 
   
    <li class="menu-item  ">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="Users">Users</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item ">
          <a href="{{ route('users.index') }}" class="menu-link">
            <div data-i18n="List">List</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons ti ti-settings'></i>
        <div data-i18n="Roles & Permissions">Roles Management</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{ route('roles.index') }}" class="menu-link">
            <div data-i18n="Roles">Roles</div>
          </a>
        </li>
      </ul>
    </li>
    <!-- allote -->
    <li class="menu-item  ">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-id"></i>
        <div >Alloties</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item ">
          <a href="{{ route('allote.index') }}" class="menu-link">
            <div data-i18n="List">List</div>
          </a>
        </li>
      </ul>
    </li>

    <!-- plot setup  -->
    <li class="menu-header small">
      <span class="menu-header-text">Apps &amp; Pages</span>
    </li>
    <li class="menu-item" style="">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-map"></i>
        <div>Plots</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
              <a href="{{ route('allotment.form') }}" class="menu-link">
                <div>Plot Allotment</div>
              </a>
            </li>

        <li class="menu-item" style="">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <div >Setup</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">
              <a href="{{ route('plot.size') }}" class="menu-link">
                <div>Plot size</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('plot.location') }}" class="menu-link">
                <div>Location</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('plot.installments') }}" class="menu-link">
                <div>Installments & Mid Payments</div>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <!-- Scheme  -->
    <li class="menu-item" style="">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-color-swatch"></i>
        <div>Schemes</div>
      </a>
      <ul class="menu-sub">

        <li class="menu-item">
              <a href="{{ route('scheme.index') }}" class="menu-link">
                <div>Schemes List</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('scheme.plots') }}" class="menu-link">
                <div>Scheme Plots</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{ route('alloted.index') }}" class="menu-link">
                <div>Alloted Plots</div>
              </a>
            </li>
      </ul>
    </li>
    <li class="menu-header small">
      <span class="menu-header-text" >Finance</span>
    </li>

    <li class="menu-item" style="">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-file-dollar"></i>
        <div>Finance</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
              <a href="{{ route('cashbook.read') }}" class="menu-link">
                <div>Cash Book</div>
              </a>
            </li>

        <li class="menu-item" style="">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <div >Setup</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">
              <a href="{{ route('account-head.read') }}" class="menu-link">
                <div>Account Heads</div>
              </a>
            </li>
            <li class="menu-item active">
              <a href="{{ route('bank.index') }}" class="menu-link">
                <div>Banks</div>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    
  </ul>
  
  

</aside>