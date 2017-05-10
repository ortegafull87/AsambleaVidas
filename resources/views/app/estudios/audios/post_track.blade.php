@extends('layouts.app')

@section('titlepage')
    <title>vivelator&aacute;.org | Inicio</title>
@endsection

@section('stylesapp')
    <link href="{{ asset('/css/app/post_track.css'). '?v='. env('APP_VERSION') }}" rel="stylesheet">
@endsection

@section('contentheader')
    <?php $audio = $audio[0];?>
    <section class="content-header">
        <h1>

            <small></small>
        </h1>
        <!--<form class="searchform">
            <input type="text" value="Buscar..." onfocus="if (this.value == 'Buscar...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Buscar...';}" />
            <input type="button" value="Ir" />
        </form>-->
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Estudios</a></li>
            <li><a href="{{asset('estudios/audios/all')}}">Audios</a></li>
            <li class="active">{{$audio->title}}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-push-8"><!-- Aside -->
            <div class="box box-info">
                <div class="box-body">
                    @include('app.estudios.audios.post_track_info')
                </div>
                <div class="box-footer clearfix"></div>
            </div>
        </div><!--/ Aside -->
        <div class="col-md-8 col-md-pull-4"><!-- Section -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h1 class="box-title"><i class="ion-ios-musical-notes" aria-hidden="true">
                        </i> {{$audio->title}}
                    </h1>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool">
                            <i class="fa fa-font"></i>a
                        </button>
                        <button type="button" class="btn btn-box-tool">
                            <i class="fa fa-file-pdf-o"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body post-audio_description">
                    @if(strlen($audio->description)>0)
                        <?php echo $audio->description;?>
                    @else
                        @include('app.comun.no-content-message')
                    @endif
                </div>
                <div class="box-footer clearfix">
                    <!-- Code here -->
                </div>
            </div><!-- /Box-info -->
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="do-comment">
                        <div class="row">
                            <div class="col-xs-2 col-md-1 text-center">
                                <img class="img-circle img-bordered-sm" src="@include('comun.imageprofile')" height="60"
                                     width="60">
                            </div>
                            <div class="col-xs-10 col-md-11" style="padding: 2.1%;padding-left: 29px;">
                                <div class="input-group input-group-md">
                                    <input id='txt_post'
                                           data-url="{{asset('estudios/audios/post/'.$audio->id.'/setPostTrack')}}"
                                           type="text"
                                           class="form-control" placeholder="Añade un comentario...">
                            <span class="input-group-btn">
                                <button id='btn_post' type="button" class="btn btn-info btn-flat">Comentar</button>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="post">
                        @include('app.comun.post')
                    </div>
                </div>
                <div class="box-footer clearfix text-center">
                    <button type="button" class="btn btn-default">Mostrar más</button>
                </div>
            </div>
        </div><!-- /Section -->
    </div>
    @include('app.comun.modals.share_modal');
@endsection

@section('scriptsapp')
    <script src="{{asset('/plugins/jquery-md5/jquery-md5.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/bootcomplete/jquery.bootcomplete.js') }}" type="text/javascript"></script>
    <script src="{{asset('/js/app/estudios/audios/Audio.js') . '?v='. env('APP_VERSION')}}"
            type="text/javascript"></script>
    <script src="{{asset('/js/app/estudios/audios/AudioService.js'). '?v='. env('APP_VERSION')}}"
            type="text/javascript"></script>
@endsection