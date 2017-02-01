<!-- Side Navigation -->
<ul id="slide-out" class="side-nav fixed">
  <li class="header"><a class="navbar-brand" href="index.html">iColumn CRM</a></li>

  <li>
      <a href="/admin"><i class="material-icons">explore</i> Dashboard</a>
  </li>
  <li class="no-padding">
    <ul class="collapsible collapsible-accordion">
      @role('administrator|manager')
      <li>
        <a href="#" class="collapsible-header"><i class="material-icons">store</i> Branch<i class="material-icons right">arrow_drop_down</i></a>
        <div class="collapsible-body">
          <ul>
              @role('administrator')
              <li><a href="/branch/create">Create</a></li>
              <li><a href="/branch">View</a></li>
              @endrole
              <li><a href="/branch/show-users/{{ Auth::user()->company_id }}">View Users</a></li>
              <li><a href="/branch/add-manager">Add Manager</a></li>
              <li><a href="/branch/add-staff">Add Staff</a></li>
          </ul>
        </div>
      </li>
      @endrole
      @role('administrator|manager|staff')
      <li>
        <a href="#" class="collapsible-header"><i class="material-icons">face</i> Members<i class="material-icons right">arrow_drop_down</i></a>
        <div class="collapsible-body">
          <ul>
              <li><a href="/member/create">Create</a></li>
              <li><a href="/member">View</a></li>
              <li><a href="/member/export">Export</a></li>
          </ul>
        </div>
      </li>
      <li>
        <a href="#" class="collapsible-header"><i class="material-icons">credit_card</i> Transactions<i class="material-icons right">arrow_drop_down</i></a>
        <div class="collapsible-body">
          <ul class="nav nav-second-level">
            <li>
                <a href="/transaction">View</a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <a href="#" class="collapsible-header"><i class="material-icons">loyalty</i> Loyalty Points Program<i class="material-icons right">arrow_drop_down</i></a>
        <div class="collapsible-body">
          <ul class="nav nav-second-level">
            <li>
                <a href="/loyalty/">List</a>
            </li>
            <li>
                <a href="/loyalty/create">Add Settings</a>
            </li>
            <li>
                <a href="/member/points-log">Points Logs</a>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <a href="#" class="collapsible-header"><i class="material-icons">card_giftcard</i> Rewards<i class="material-icons right">arrow_drop_down</i></a>
        <div class="collapsible-body">
          <ul class="nav nav-second-level">
              <li>
                  <a href="/rewards/">Rewards List</a>
              </li>
              <li>
                  <a href="/rewards/create">Add Rewards</a>
              </li>
          </ul>
        </div>
      </li>
      <li>
        <a href="#" class="collapsible-header"><i class="material-icons">settings</i> Configurations<i class="material-icons right">arrow_drop_down</i></a>
        <div class="collapsible-body">
          <ul class="nav nav-second-level">
            @role('administrator')
            <li>
                <li><a href="/company/{{ Auth::user()->company_id }}">Company Details</a></li>
            </li>
            @endrole
            <li>
                <a href="/product/category/">Product Category List</a>
            </li>
            <li>
                <a href="/product/category/create">Create Product Category</a>
            </li>
            @role('administrator')
            <li>
                <li><a href="/setup">Setup</a></li>
            </li>
            @endrole
          </ul>
        </div>
      </li>
      @endrole
    </ul>
  </li>
</ul>
<!-- /.side-nav -->
<header>
<!-- Top Navigation -->
<nav class="@yield('content-theme')">
  <div class="nav-wrapper">
    <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
    <form class="nav-search left hide-on-small-only">
      <div class="input-field">
        <input id="navSearch" type="search" placeholder="Search" required>
        <label for="navSearch"><i class="material-icons">search</i></label>
        <i class="material-icons">close</i>
      </div>
    </form>
    <ul class="right">
      <li>
         <a class="dropdown-button" data-beloworigin="true" href="#" data-activates="dropdownUser">
            Welcome, {{ Auth::user()->name }} <i class="material-icons right">arrow_drop_down</i>
        </a>
      </li>
    </ul>
    <!-- /.right -->
  </div>
</nav>
<ul id="dropdownUser" class="dropdown-content dropdown-user">
    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
    </li>
    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
    </li>
    <li class="divider"></li>
    <li><a href="{{ url('/admin/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
    </li>
</ul>
<!-- /.dropdown-user -->
</header>
