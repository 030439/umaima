<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  
  <div class="app-brand demo" style="height:90px">
    <a href="{{route('dashboard.index')}}" class="app-brand-link">
      <span class="">
      <img src="../../assets/deluxe.jpg" height="120" width="150">
</span>
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
  
    <li class="menu-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <a href="{{ route('dashboard.index') }}" class="menu-link">
            <i class="menu-icon tf-icons ti ti-smart-home"></i>
            <div data-i18n="Dashboards">Dashboards</div>
        </a>
    </li>


  
   
    <li class="menu-item {{ request()->routeIs('users.*') ? 'active open' : '' }} ">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="Users">Users</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('users.index') ? 'active' : '' }} ">
          <a href="{{ route('users.index') }}" class="menu-link">
            <div data-i18n="List">List</div>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item {{ request()->routeIs('roles.*') ? 'active open' : '' }}">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class='menu-icon tf-icons ti ti-settings'></i>
        <div data-i18n="Roles & Permissions">Roles Management</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('roles.index') ? 'active' : '' }}">
          <a href="{{ route('roles.index') }}" class="menu-link">
            <div data-i18n="Roles">Roles</div>
          </a>
        </li>
      </ul>
    </li>
    <!-- allote -->
    <li class="menu-item {{ request()->routeIs('allote.index') ? 'active open' : '' }} ">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-id"></i>
        <div >Alloties</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('allote.index') ? 'active' : '' }}">
          <a href="{{ route('allote.index') }}" class="menu-link">
            <div data-i18n="List">List</div>
          </a>
        </li>
      </ul>
    </li>

    <li class="menu-item {{ request()->routeIs('allotment.*') ||request()->routeIs('plot.*') ? 'active open' : '' }}" style="">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-map"></i>
        <div>Plots</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('allotment.form') ? 'active' : '' }}">
              <a href="{{ route('allotment.form') }}" class="menu-link">
                <div>Plot Allotment</div>
              </a>
            </li>

        <li class="menu-item {{ request()->routeIs('plot.*') ? 'active open' : '' }}" style="">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <div >Setup</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('plot.size') ? 'active' : '' }}">
              <a href="{{ route('plot.size') }}" class="menu-link">
                <div>Plot size</div>
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('plot.location') ? 'active' : '' }}">
              <a href="{{ route('plot.location') }}" class="menu-link">
                <div>Location</div>
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('plot.installments') ? 'active' : '' }}">
              <a href="{{ route('plot.installments') }}" class="menu-link">
                <div>Installments & Mid Payments</div>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <!-- Scheme  -->
    <li class="menu-item {{ request()->routeIs('scheme.*') ? 'active open' : '' }}" style="">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-color-swatch"></i>
        <div>Schemes</div>
      </a>
      <ul class="menu-sub">

        <li class="menu-item {{ request()->routeIs('scheme.index') ? 'active' : '' }}">
              <a href="{{ route('scheme.index') }}" class="menu-link">
                <div>Schemes List</div>
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('scheme.plots') ? 'active' : '' }}">
              <a href="{{ route('scheme.plots') }}" class="menu-link">
                <div>Scheme Plots</div>
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('alloted.index') ? 'active' : '' }}">
              <a href="{{ route('alloted.index') }}" class="menu-link">
                <div>Alloted Plots</div>
              </a>
            </li>
      </ul>
    </li>

    <li class="menu-item {{ request()->routeIs('cashbook.*') ? 'active open' : '' }}" style="">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-file-dollar"></i>
        <div>Finance</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item {{ request()->routeIs('cashbook.read') ? 'active' : '' }}">
          <a href="{{ route('cashbook.read') }}" class="menu-link">
            <div>Cash Book</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('expense.show') ? 'active' : '' }}">
          <a href="{{ route('expense.show') }}" class="menu-link">
            <div>Expenses</div>
          </a>
        </li>
        <li class="menu-item {{ request()->routeIs('payments.show') ? 'active' : '' }}">
          <a href="{{ route('payments.show') }}" class="menu-link">
            <div>Payments</div>
          </a>
        </li>

        <li class="menu-item" style="">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <div >Setup</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item {{ request()->routeIs('account-head.read') ? 'active' : '' }}">
              <a href="{{ route('account-head.read') }}" class="menu-link">
                <div>Account Heads</div>
              </a>
            </li>
            <li class="menu-item {{ request()->routeIs('bank.index') ? 'active' : '' }} ">
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