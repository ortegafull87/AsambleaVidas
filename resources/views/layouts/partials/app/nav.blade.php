<nav class="navbar navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a href="{{asset('')}}" class="navbar-brand"><b><img
                            src="{{ asset('/img/app/torah-icono_4_plus_2.png') }}" height="50">
                    <b style="color:#046a96;">Vivela</b><span style="color:#00abf4;">Tor&aacute;h</span></a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <!--<li class="active"><a href="#">Inicio <span class="sr-only">(current)</span></a></li>-->
                <!--<li><a href="#">Parash&aacute;</a></li>-->
                <!--<li><a href="#">Tor&aacute;h</a></li>-->
                <li class="active"><a href="{{ asset('/estudios/audios/all') }}">Audios</a></li>
            <!--<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Estudios <span
                                class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="{{ asset('/estudios/audios/all') }}">Audio</a></li>
                        <!--<li><a href="#">video</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Documentos</a></li>
                    </ul>
                </li>-->
                <!--<li><a href="#">Blog</a></li>-->
            </ul>

        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                @if(Auth::guest())
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                    <li class="btn-register"><a
                                href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                @else
                <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-comments-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image -->
                                                <img src="{{ asset(env('URL_BASE_IMGS').'/no-image-profile.png') }}" class="img-circle"
                                                     alt="User Image">
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <!-- The message -->
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                </ul>
                                <!-- /.menu -->
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
                    <!-- /.messages-menu -->

                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li><!-- start notification -->
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                     role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                     aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img id="image_profile_bar" src="@include('comun.imageprofile')" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img id="image_profile_menu" src="@include('comun.imageprofile')" class="img-circle" alt="User Image">

                                <p>
                                {{ Auth::user()->name }} <!--- Web Developer-->
                                    <small>{{ trans('adminlte_lang::message.membersince') }}
                                        . @include('comun.merbersince')</small>
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
                                    <a href="{{asset('configuration/profile')}}" class="btn btn-default btn-flat">Perfil</a>
                                </div>
                                @if(App\Library\Util::AUNTH_USER_ROOT() || App\Library\Util::AUNTH_USER_ADMIN())
                                    <div class="pull-left" style="padding-left: 3px;">
                                        <a href="{{ url('/home') }}" class="btn btn-default btn-flat">Dashboard</a>
                                    </div>
                                @endif
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Cerrar Sesión</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<!-- /.navbar-custom-menu -->
<!-- /.container-fluid -->