@extends('layouts.app')

@section('titlepage')
    <title>vivelator&aacute;.org | Inicio</title>
@endsection

@section('stylsapp')
    <link href="{{ asset('/css/app/inicio.css') }}" rel="stylesheet">
@endsection

@section('contentheader')
    <section class="content-header">
        <h1>
            Agregados recientemente
            <small></small>
        </h1>
        <!--<form class="searchform">
            <input type="text" value="Buscar..." onfocus="if (this.value == 'Buscar...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Buscar...';}" />
            <input type="button" value="Ir" />
        </form>-->
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Estudios</a></li>
            <li><a href="#">Audios</a></li>
            <li class="active">Todos</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="track-box-container">
         @include('app.estudios.audios.box_track')
    </div>
@endsection

@section('scriptsapp')
    <script type="text/javascript">
            $(function() {
                $('.example').barrating({
                    theme: 'fontawesome-stars'
                });
            });
</script>
    <script src="{{asset('/js/app/estudios/audios/Audio.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/app/estudios/audios/AudioService.js')}}" type="text/javascript"></script>
@endsection