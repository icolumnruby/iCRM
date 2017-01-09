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

        <!-- Bootstrap Core CSS -->
        <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootstrap-switch.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootstrap-social.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

        <link rel="stylesheet" href="{{ URL::asset('css/formValidation.min.css') }}">

        <!-- MetisMenu CSS -->
        <link href="{{ URL::asset('css/metisMenu.min.css') }}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ URL::asset('css/sb-admin-2.css') }}" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="{{ URL::asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

        <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
         <!-- jQuery -->
        <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

    </head>

    <body>

        <div id="wrapper">
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">iColumn CRM</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <!-- /.dropdown -->
                    <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="{{ url('/admin/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

            </nav>
            <div class="navbar-default navbar-fixed-top sidebar scrollable" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="/admin"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        @role('administrator')
                        <li>
                            <a href="/contact"><i class="fa fa-sitemap fa-fw"></i> Company<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="/company/create">Create</a></li>
                                <li><a href="/company">View</a></li>
                            </ul>
                        </li>
                        @endrole
                        @role('administrator|manager')
                        <li>
                            <a href="/contact"><i class="fa fa-sitemap fa-fw"></i> Branch<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                @role('administrator')
                                <li><a href="/branch/create">Create</a></li>
                                <li><a href="/branch">View</a></li>
                                @endrole
                                <li><a href="/branch/show-users/{{ Auth::user()->company_id }}">View Users</a></li>
                                <li><a href="/branch/add-manager">Add Manager</a></li>
                                <li><a href="/branch/add-staff">Add Staff</a></li>
                            </ul>
                        </li>
                        @endrole
                        @role('administrator|manager|staff')
                        <li>
                            <a href="/member"><i class="fa fa-users fa-fw"></i> Members<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="/member/create">Create</a></li>
                                <li><a href="/member">View</a></li>
                                <li><a href="/member/export">Export</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-credit-card fa-fw"></i> Transactions<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/transaction">View</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-tags fa-fw"></i> Loyalty Points Program<span class="fa arrow"></span></a>
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
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-money fa-fw"></i> GWP<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="">Campaigns</a>
                                </li>

                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-cogs fa-fw"></i> Configurations<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/product/category/">Product Category List</a>
                                </li>
                                <li>
                                    <a href="/product/category/create">Create Product Category</a>
                                </li>
                                <li>
                                    <a href="/rewards/">Rewards List</a>
                                </li>
                                <li>
                                    <a href="/rewards/create">Add Rewards</a>
                                </li>
                                <li>
                                    <a href="/rewards/create">Create PassSlot Template</a>
                                </li>
                            </ul>
                        </li>
                        @endrole
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->

             <!-- Page Content -->
            <div id="page-wrapper">
                @yield('content')
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- Bootstrap Core JavaScript -->
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap-switch.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/formValidation.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/formValidation.bootstrap.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap-datetimepicker.min.js') }}"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="{{ URL::asset('js/sb-admin-2/metisMenu.min.js') }}"></script>

        <!-- Custom Theme JavaScript -->
        <script src="{{ URL::asset('js/sb-admin-2/sb-admin-2.js') }}"></script>
    </body>
</html>