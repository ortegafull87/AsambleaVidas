<!DOCTYPE html>
<html>
<head>
    @include('layouts.partials.app.head')
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-black layout-top-nav">
<div class="wrapper">
    <header class="main-header">
    </header>
    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container">

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
