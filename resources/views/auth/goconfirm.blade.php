@extends('layouts.auth')

@section('htmlheader_title')
    Confirm
@endsection

@section('content')
    <style>
        .login-box {
            width: 500px;
        }

        .login-box-msg i {
            font-size: 60px;

            -ms-transform: rotate(-13deg); /* IE 9 */
            -webkit-transform: rotate(-13deg); /* Safari */
            transform: rotate(-13deg); /* Standard syntax */
        }
        .login-box-msg{
            font-size: larger;
            text-align: justify;
        }
    </style>
    <body class="hold-transition login-page" data-base="{{ asset('/') }}">
    <div class="login-box">
        <div class="login-logo">
            <span class="logo-lg"><img src="{{ asset('/img/app/torah-icono_4_plus_2.png') }}" height="40"></span><a
                    href="{{ url('/home') }}"><b>vivela</b>tor&aacute;h</a>
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
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </p>
                </div>
                <div class="col-xs-10">
                    <p class="login-box-msg"> {{$data['name']}} hemos enviado un email a la direcci&oacute;n que nos
                        proporcionaste,
                        confirma tu cuenta para poder terminar el registro.
                    </p>
                </div>
            </div>

            <p class="login-box-msg">Si no has recibido ningún correo con el título
                "<b>confirma tu cuenta</b>", has<a href="#"> click aquí</a> para renviarlo, o <a href=""> actualiza tu e-mail</a>.</p>

        </div><!-- /.login-box-body -->
        @include('auth.partials.socials')
        @include('auth.partials.politics')
        @include('auth.partials.copyright')

    </div><!-- /.login-box -->


    @include('layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
    </body>

@endsection
