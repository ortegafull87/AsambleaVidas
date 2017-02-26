@extends('layouts.app')

@section('titlepage')
    <title>vivelator&aacute;.org | Perfil</title>
@endsection

@section('stylsapp')
    <link href="{{ asset('/css/app/inicio.css') }}" rel="stylesheet">
@endsection

@section('contentheader')
    <section class="content-header">
        <h1>
            Perfil
            <small></small>
        </h1>
        <!--<form class="searchform">
            <input type="text" value="Buscar..." onfocus="if (this.value == 'Buscar...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Buscar...';}" />
            <input type="button" value="Ir" />
        </form>-->
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Configuración</a></li>
            <li class="active"><a href="#">Perfil</a></li>
        </ol>
    </section>
@endsection

@section('content')

@endsection

@section('scriptsapp')

@endsection