@extends('layouts.app')

@section('titlepage')
    <title>vivelator&aacute;.org | Perfil</title>
@endsection

@section('stylsapp')
    <link href="{{ asset('/css/app/inicio.css') }}" rel="stylesheet">
@endsection

@section('contentheader')
    <?php $user = $user[0]?>
    <section class="content-header">
        <h1>
            Perfil
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{asset('')}}"><i class="fa  fa-home"></i>Inicio</a></li>
            <li class="active"><a href="#">Configuración</a></li>
            <li class="active"><a href="#">Perfil</a></li>
        </ol>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                @include('app.config.profileleftcol')
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                @include('app.config.profilerightcol')
            </div>
            <!-- /.row -->
        </div>
    </section>
    @include('app.comun.modals.image_modal')
    @include('app.comun.modals.password_modal')
@endsection

@section('scriptsapp')
    <script src="{{asset('/js/mapa/google.map.js')}}" type="text/javascript"></script>
    <script id="google_api" data-key="AIzaSyCKvTFXSVIgSEVS_bOrNh0h_Wlg6SRq9wQ"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKvTFXSVIgSEVS_bOrNh0h_Wlg6SRq9wQ&callback=initMap"
            async defer></script>
    <script src="{{asset('/plugins/jquery-md5/jquery-md5.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/plugins/input-mask/jquery.inputmask.js')}}" type="text/javascript"></script>
    <script src="{{asset('/plugins/input-mask/jquery.inputmask.date.extensions.js')}}" type="text/javascript"></script>
    <script src="{{asset('/plugins/input-mask/jquery.inputmask.extensions.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/app/config/Profile.js?')}}{{env('APP_VERSION')}}" type="text/javascript"></script>
    <script src="{{asset('/js/app/config/ProfileService.js?')}}{{env('APP_VERSION')}}" type="text/javascript"></script>
    <script>
        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/aaaa"});
    </script>
@endsection