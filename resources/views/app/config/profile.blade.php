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
            <li class="active" ><a href="#">Configuración</a></li>
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
@endsection

@section('scriptsapp')
    <script src="{{asset('/js/app/config/Profile.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/app/config/ProfileService.js')}}" type="text/javascript"></script>
@endsection