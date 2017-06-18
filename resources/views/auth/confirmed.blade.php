@extends('layouts.auth')

@section('htmlheader_title')
    confirm
@endsection

@section('content')
    <style>
        .login-box {
            width: 500px;
        }

        .login-box-msg i {
            font-size: 60px;
            color: #046a96;
        }

        .login-box-msg {
            font-size: larger;
            text-align: justify;
        }
    </style>
    <body class="hold-transition login-page" data-base="{{ asset('/') }}">
    <div class="login-box">
        <div class="login-logo">
            <span class="logo-lg"><img src="{{ asset('/img/app/torah-icono_4_plus_2.png') }}" height="50"></span><a
                    href="{{ url('/home') }}"><b style="color:#046a96;">vivela</b><span style="color:#00abf4;">Toráh</span></a>
        </div><!-- /.login-logo -->

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="login-box-body">
            <div class="row">
                <div class="col-xs-2">
                    <p class="login-box-msg">
                        <i class="fa fa-check" aria-hidden="true"></i>
                    </p>
                </div>
                <div class="col-xs-10">
                    <p class="login-box-msg">¡Felicidades!.
                        <br>Tu cuenta ha sido confirmada, has click en el bot&oacute;n de abajo
                        para iniciar sesión.
                    </p>
                </div>
                <div class="col-xs-12 text-center">
                    <button type="button" class="btn btn-info">Iniciar sesión</button>
                </div>
            </div>

        </div><!-- /.login-box-body -->
        @include('auth.partials.socials')
        @include('auth.partials.politics')
        @include('auth.partials.copyright')
    </div><!-- /.login-box -->


    @include('layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('button').click(function () {
                var base = $('body').data('base');
                window.location.replace(base + "login");
            });
        });
    </script>
    </body>

@endsection
