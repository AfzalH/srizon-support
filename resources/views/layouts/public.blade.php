<!DOCTYPE html>
<!--
                                                ZZZZ$D
         8OZZO8N                               ZZZZZON
     ZZZZZZZZZZZZZZZ                            ZZZ
   ZZZZZZZZZZZZZZZNNZN                          Z$
  ZZZZZZZZ8   NZZZZZ8         D     D8888D                                        N$$D8$
 OZZZZZ            OO         8N N88888888DD                                       ZZZZZZDZ           8   N888D88N
 8ZZZZZ                     8DD8N8888D D888N                   NNN               ZZZ$$N$ZZZ8$      8N88D 8888888888
 NZZZZZO                    N88888888    N88  ZZZZZ     8888888888888888DN     $ZZZ$ZZ8Z$ZZZZZN    8D8888888D88D888DD
  8ZZZZZZZZO                 888888N          ZZZZZ  N88888888888888888888D8  ZZZZZZZ     ZZZZO$   888888888N   N8888
   NZZZZZZZZZZZZOD           888888           ZZZZ$     888D8888888D88888888 Z$ZZZ$        $ZZZZ   88888888D     8888D
     NZZZZZZZZZZZZZZZ8       88888N          NZZZZZ                N8D88888DZZZZZZ          ZZZZZ  88888888      ND88DN
         ONOZZZZZZZZZZZZ     8888D8          8ZZZZZ            N 8D88888888 ZZZZZ            ZZZZN 8888888N       D888D
              8Z Z$ZZZZZ$8   88888D          OZZZZO         N888888888888  $ZZZZO            $ZZZO 888888N        88888
                   OOZZZZZ8  ND888            ZZZZ        N888888888DD     $ZZZZO            $ZZZO 888888D        8N88D
                     DOZZZZ   8888N          ZZZZZ    ND8D8888888N         OZZZZZ            DZZON 888888D          88D
                      8ZZZZ   88888          ZZZZO   N888888DD              ZZZZZ          NOZZZ$  888888           88ND
                     DZZZZZ   N88888        NDZZZ   N8888N8D                ZZZZZZ        ZZZZZO8  88888D           88ND
    DDDDDDDDDD8OZDZZZZZZZZ     88888         DZZZ   DD88DNNNNDD8888DDNNN     ZZZZZZZZ$ZZZZZZZZ$    888888           88
ZZZZZZZZZZZZZZZZZZZZZZZZZ      88888        ZOZZZ   DD8888888888888888888     ZZZZZZZZZZZZZZZD     888888           88
  NZZZZZZZZZZZZZZZZZZZN        88888        ZZZZZ   DND88DDDD888DD8888888888D  8OZZZZZZZZ$ N       88888
    8OZZZZZZZOONN                            NZ                      N88N          N$$8                D
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@if(isset($pagetitle)) {{$pagetitle.' - Srizon Support'}} @else {{'Srizon Support'}} @endif</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <script>
        var recent_tickets_url = '{{route('ticket.recent')}}';
    </script>
    <link rel="stylesheet" href="{{url('/css/all.css')}}">
    <link rel="stylesheet" href="{{url('/css/skin-public.css')}}">
    {{--    <link rel="stylesheet" href="{{url('/css/dev.css')}}">--}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{url('/img/favicon.ico')}}" rel="shortcut icon" type="image/vnd.microsoft.icon"/>
    <!-- Ionicons -->
    {{--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">--}}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @if(Gate::denies('support'))
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', '{{env('GOOGLE_ANALYTICS_CODE')}}', 'auto');
        ga('send', 'pageview');
    </script>
    @endif

</head>
<body class="sidebar-collapse skin-public public layout-top-nav">
<div class="wrapper">
    <!-- Main Header -->
    <div class="">
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a @if(Route::current()->getPath() == '/') href="https://www.srizon.com"
                           @else href="{{url('/')}}"
                           @endif class="navbar-brand"><img
                                    src="https://www.srizon.com/images/logo.svg" alt="Srizon" width="80"
                                    height="22"></a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                data-target="#navbar-collapse">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">

                        {{Form::open(['method'=>'get','route'=>'ticket.public.search','class'=>'navbar-form navbar-left','role'=>'search'])}}
                        <div class="form-group">
                            <input type="text" name="q" class="form-control" id="navbar-search-input"
                                   placeholder="Search Ticket">
                            <input type="submit" value="Go" class="btn btn-primary btn-flat hidden-sm hidden-xs">
                        </div>
                        {{Form::close()}}
                    </div>
                    <!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li><a href="{{route('ticket.list')}}"><span>All Tickets</span></a></li>

                            @if(Gate::allows('support'))
                                <li>
                                    <a href="{{route('dashboard')}}"><span>Admin</span></a>
                                </li>
                            @else
                                <li class="dropdown messages-menu">
                                    <!-- Menu toggle button -->
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <span>About</span>
                                        {{--<span class="label label-warning">?</span>--}}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="header"><span>Welcome to SrizonSupport</span>
                                        </li>
                                        <li class="header">
                                    <span class="drop-body">
                                        <strong>This app allows you to:</strong><br>
                                        <span class="fa fa-green fa-check"></span> Create support tickets without Login/Registration.<br>
                                        <span class="fa fa-green fa-check"></span> Follow the progress transparently.<br>
                                        <span class="fa fa-green fa-check"></span> Share private info with support staff (credentials/links etc.)<br>
                                        <span class="fa fa-green fa-check"></span> See other's tickets, progress, replies (excluding the private section of course)<br>
                                    </span>
                                        </li>
                                        {{--<li class="footer"><a href="#">Learn More</a></li>--}}
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!-- /.navbar-custom-menu -->
                </div>
                <!-- /.container-fluid -->
            </nav>
        </header>
    </div>

    <!-- Content Wrapper. Contains page content -->
    <div class="">
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('header')
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="container">
                    @include('flash::message')
                    @include('errors.bag')
                </div>

                @yield('content')

            </section>
            <!-- /.content -->
        </div>
    </div>
    <!-- /.content-wrapper -->

</div>
<!-- ./wrapper -->
<script src="{{url('/js/all.js')}}"></script>
{{--<script src="{{url('/js/dev.js')}}"></script>--}}
@include('parts.tinymce')
@yield('extrascripts')

</body>
</html>
