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
                    <div class="do-comment">

                        <div class="input-group">
                                <span class="input-group-addon" style="padding: 0;">
                                                            <img alt="32x32" class="media-object"
                                                                 data-src="holder.js/32x32"
                                                                 style="width: 32px; height: 32px;"
                                                                 src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHZpZXdCb3g9IjAgMCA2NCA2NCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PCEtLQpTb3VyY2UgVVJMOiBob2xkZXIuanMvNjR4NjQKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNTlkZThlMjQ2MiB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1OWRlOGUyNDYyIj48cmVjdCB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSIxNCIgeT0iMzYuNSI+NjR4NjQ8L3RleHQ+PC9nPjwvZz48L3N2Zz4="
                                                                 data-holder-rendered="true">
                                </span>
                            <input type="text" class="form-control" placeholder="Añade un comentario...">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat">Comentar</button>
                            </span>
                        </div>
                    </div>
                    <div class="comments">
                        @include('app.comun.comments')
                    </div>

                </div>
            </div>
        </div><!-- /Section -->
    </div>
@endsection

@section('scriptsapp')
    <script src="{{asset('/js/app/estudios/audios/Audio.js') . '?v='. env('APP_VERSION')}}"
            type="text/javascript"></script>
    <script src="{{asset('/js/app/estudios/audios/AudioService.js'). '?v='. env('APP_VERSION')}}"
            type="text/javascript"></script>
@endsection