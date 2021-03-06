<head>
    <meta charset="UTF-8">
    <title> @yield('htmlheader_title') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <!-- Dinamic Head Content -->
    @yield('dinamic_head_content')
    <!--<link href="{{ asset('/css/skins/skin-blue.css') }}" rel="stylesheet" type="text/css" />-->
    <link href="{{ asset('/css/skins/skin-black-light.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{{ asset('/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('/css/dropzone.css') }}" rel="stylesheet" type="text/css" />
    <!-- Mini audio -->
    <link href="{{ asset('/plugins/jquery.mb.miniAudioPlayer-1.8.5/dist/css/jQuery.mb.miniAudioPlayer.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- sweetalert -->
       <link href="{{ asset('/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- dashboard-->
    <link href="{{ asset('/css/dashboard/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <!-- pnotify -->
    <link href="{{ asset('/plugins/pnotify/pnotify.custom.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Comunes -->
    <link href="{{ asset('/css/comunes.css') }}" rel="stylesheet" type="text/css" />
    <!-- bootstrap-wysihtml5 -->
    <link href="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <meta name="csrf-token" content="{{ csrf_token()}}">
</head>
