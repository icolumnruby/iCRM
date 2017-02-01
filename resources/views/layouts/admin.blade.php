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
        <link href="{{ URL::asset('css/material-icons.css') }}" rel="stylesheet">
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
      @include('layouts.header')
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
        @if($errors->any())
<h4>{{$errors->first()}}</h4>
@endif
         <!-- Page Content -->
        <div id="page-wrapper" class="container">
            @yield('content')
        </div>
        <!-- /#page-wrapper -->
      </main>
        <!-- Materialize JavaScript -->
        <script src="{{ URL::asset('js/materialize.min.js') }}"></script>
        <script src="{{ URL::asset('js/materialize-colorpicker.min.js') }}"></script>
        <script src="{{ URL::asset('js/dropzone.js') }}"></script>

        <!-- Bootstrap Core JavaScript -->
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap-switch.min.js') }}"></script>

        <script type="text/javascript" src="{{ URL::asset('js/bootstrap-datetimepicker.min.js') }}"></script>

        <!-- Custom Theme JavaScript -->
        <script src="{{ URL::asset('js/main.js') }}"></script>
    </body>
</html>
