<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <title>iColumn CRM - Admin</title>

        <!-- App CSS -->
        <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootstrap-switch.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootstrap-social.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="{{ URL::asset('css/formValidation.min.css') }}">

        <!-- Icons -->
        <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
         <!-- jQuery -->
        <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/parsley.min.js') }}"></script>

    </head>

    <body>
      <!-- Side Navigation -->
      <ul id="slide-out" class="side-nav fixed">
        <li class="header"><a class="navbar-brand" href="index.html">iColumn CRM</a></li>

        <li>
            <a href="/admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
        </li>
        <li class="no-padding">
          <ul class="collapsible collapsible-accordion">
            @role('administrator|manager')
            <li>
              <a href="#" class="collapsible-header"><i class="fa fa-sitemap fa-fw"></i> Branch<i class="material-icons right">arrow_drop_down</i></a>
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
              <a href="#" class="collapsible-header"><i class="fa fa-users fa-fw"></i> Members<i class="material-icons right">arrow_drop_down</i></a>
              <div class="collapsible-body">
                <ul>
                    <li><a href="/member/create">Create</a></li>
                    <li><a href="/member">View</a></li>
                    <li><a href="/member/export">Export</a></li>
                </ul>
              </div>
            </li>
            <li>
              <a href="#" class="collapsible-header"><i class="fa fa-credit-card fa-fw"></i> Transactions<i class="material-icons right">arrow_drop_down</i></a>
              <div class="collapsible-body">
                <ul class="nav nav-second-level">
                  <li>
                      <a href="/transaction">View</a>
                  </li>
                </ul>
              </div>
            </li>
            <li>
              <a href="#" class="collapsible-header"><i class="fa fa-tags fa-fw"></i> Loyalty Points Program<i class="material-icons right">arrow_drop_down</i></a>
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
              <a href="#" class="collapsible-header"><i class="fa fa-money fa-fw"></i> Rewards<i class="material-icons right">arrow_drop_down</i></a>
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
              <a href="#" class="collapsible-header"><i class="fa fa-cogs fa-fw"></i> Configurations<i class="material-icons right">arrow_drop_down</i></a>
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
      <main class="@yield('content-theme')">
        @if(Session::has('flash_message'))
            <div class="alert alert-success">
                {!! Session::get('flash_message') !!}
            </div>
        @elseif(Session::has('error_message'))
            <div class="alert alert-error">
                {!! Session::get('error_message') !!}
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif
         <!-- Page Content -->
        <div id="page-wrapper" class="container">
            @yield('content')
        </div>
        <!-- /#page-wrapper -->
      </main>
        <!-- Materialize JavaScript -->
        <script src="{{ URL::asset('js/materialize.min.js') }}"></script>

        <!-- Bootstrap Core JavaScript -->
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap-switch.min.js') }}"></script>

        <script type="text/javascript" src="{{ URL::asset('js/bootstrap-datetimepicker.min.js') }}"></script>

        <!-- Custom Theme JavaScript -->
        <script src="{{ URL::asset('js/main.js') }}"></script>
    </body>
</html>
