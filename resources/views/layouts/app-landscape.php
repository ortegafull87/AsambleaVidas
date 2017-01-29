<!DOCTYPE html>
<html>
<head>
    @include('layouts.partials.app.head')
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-black layout-top-nav">
<div class="wrapper">
    <header class="main-header">
        <!-- Navigation menu -->
        @include('layouts.partials.app.nav')
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container">
            <!-- Content Header (Page header) -->
            @yield('contentheader')
            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content-wrapper -->
    @include('layouts.partials.app.footer')
</div>
<!-- ./wrapper -->
@include('layouts.partials.app.scripts')
</body>
</html>
