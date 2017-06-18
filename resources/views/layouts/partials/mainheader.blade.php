<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('all/audios') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img src="{{ asset('/img/app/torah-icono_4_plus_2.png') }}" height="40"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img src="{{ asset('/img/app/torah-icono_4_plus_2.png') }}" height="50"> <b
                    style="color:#046a96;">vivela</b><span style="color:#00abf4;">Tor&aacute;h</span> </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav ">

                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
            @else

                <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="@include('comun.imageprofile')" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="@include('comun.imageprofile')" class="img-circle" alt="User Image">

                                <p>
                                {{ Auth::user()->name }} <!--- Web Developer-->
                                    <small>{{ trans('adminlte_lang::message.membersince') }}
                                        . {{ \App\Library\Util::FORMAT_DATE_TO(Auth::user()->created_at,'M Y') }}</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-6 text-center">
                                        <a href="#">&Uacute;ltima entrada:</a>
                                    </div>
                                    <div class="col-xs- text-center">
                                        <a href="#">{{Auth::user()->created_at}}</a>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </li>                            <!-- Menu Footer-->

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Perfil</a>
                                </div>
                                @if(App\Library\Util::AUNTH_USER_ROOT() || App\Library\Util::AUNTH_USER_ADMIN())
                                    <div class="pull-left" style="padding-left: 25px;">
                                        <a href="{{ url('all/audios') }}" class="btn btn-default btn-flat">App</a>
                                    </div>
                                @endif
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Cerrar Sesión</a>
                                </div>
                            </li>
                        </ul>
                    </li>
            @endif

            <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
