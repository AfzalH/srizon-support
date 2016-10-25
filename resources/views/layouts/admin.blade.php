<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Srizon Support</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{url('/css/all.css')}}">
{{--    <link rel="stylesheet" href="{{url('/css/dev.css')}}">--}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{url('/img/favicon.ico')}}" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <!-- Ionicons -->
    {{--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{url('/')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>S</b>RZ</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Srizon</b>Support</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            @if(! Auth::guest())
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{\Gravatar::get(\Auth::user()->email)}}" class="img-circle" alt="User">
                    </div>
                    <div class="pull-left info">
                        <p>{{\Auth::user()->name}}</p>
                        <!-- Status -->
                        <a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
                    </div>
                </div>
            @endif


            <ul class="sidebar-menu">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ route('login') }}">Login</a></li>
                @else
                    @if(Gate::allows('support') or Gate::allows('super'))
                        <li><a href="{{route('dashboard')}}"><i
                                        class="fa fa-dashboard"></i><span>Dashboard</span></a></li>

                        <li class="header">Ticket Related</li>
                        <li><a href="{{route('super.ticket.index')}}"><i
                                        class="fa fa-th-large"></i><span>Tickets</span></a></li>
                        @can('super')
                        <li><a href="{{route('super.ticketstatus.index')}}"><i
                                        class="fa fa-tasks"></i><span>Ticket Statuses</span></a></li>
                        <li><a href="{{route('super.ticketcategory.index')}}"><i class="fa fa-sitemap"></i><span>Ticket Categories</span></a>
                        </li>

                        <li class="header">Order Related</li>
                        <li><a href="{{ route('super.order.index') }}"><i
                                        class="fa fa-shopping-cart"></i><span>Orders</span></a></li>
                        @if(env('TEST_MODE', false) == true)
                            <li><a href="{{ route('super.order.ipntest') }}"><i
                                            class="fa fa-chain"></i><span>IPN Check</span></a></li>
                        @endif
                        @endcan

                        <li class="header">Product Related</li>
                        @can('super')
                        <li><a href="{{route('super.product-category.index')}}"><i class="fa fa-sitemap"></i><span>Categories</span></a>
                        </li>
                        <li><a href="{{route('super.products.index')}}"><i class="fa fa-gift"></i><span>Products</span></a>
                        </li>
                        <li><a href="{{route('super.productlink.index')}}"><i class="fa fa-download"></i><span>Download Links</span></a>
                        </li>
                        @endcan

                        <li><a href="{{route('super.reply-template.index')}}"><i class="fa fa-clipboard"></i><span>Reply Templates</span></a>
                        </li>

                        @can('super')
                        <li class="header">User Related</li>
                        <li><a href="{{ route('super.user.index') }}"><i class="fa fa-users"></i><span>Users</span></a>
                        </li>
                        <li><a href="{{ route('super.role.index') }}"><i
                                        class="fa fa-suitcase"></i><span>Roles</span></a>
                        </li>
                        <li><a href="{{ route('super.permission.index') }}"><i
                                        class="fa fa-key"></i><span>Permissions</span></a></li>
                        @endcan
                    @endif
                @endif
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield('header')
        </section>

        <!-- Main content -->
        <section class="content">

            @include('flash::message')
            @include('errors.bag')

            @yield('content')

        </section>
        <div class="floating-callout-box"></div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    {{--<footer class="main-footer">--}}
    <!-- To the right -->
    {{--<div class="pull-right hidden-xs">--}}
    {{--Anything you want--}}
    {{--</div>--}}
    <!-- Default to the left -->
    {{--<strong>Copyright &copy; 2015 <a href="#">Company</a>.</strong> All rights reserved.--}}
    {{--</footer>--}}

</div>
<!-- ./wrapper -->
<script src="{{url('/js/all.js')}}"></script>
{{--<script src="{{url('/js/dev.js')}}"></script>--}}
@include('parts.tinymce')
@yield('extrascripts')

        <!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
