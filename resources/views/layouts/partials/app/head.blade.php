<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
@yield('titlepage')
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
<!-- Theme style -->
<link href="{{ asset('/css/AdminLTE.min.css') }}" rel="stylesheet">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link href="{{ asset('/css/skins/_all-skins.min.css') }}" rel="stylesheet">
<!-- clases comunes -->
<link href="{{ asset('/css/app/comun.css') }}" rel="stylesheet">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('/plugins/jQuery-bar-rating/dist/themes/fontawesome-stars.css') }}">
<!-- toast -->
<link href="{{ asset('/plugins/toast/jquery.toast.min.css') }}" rel="stylesheet" type="text/css" />
@yield('stylesapp')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->