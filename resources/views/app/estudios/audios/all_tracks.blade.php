@extends('layouts.app')

@section('titlepage')
    <title>vivelator&aacute;.org | Inicio</title>
@endsection

@section('stylesapp')
    <link href="{{ asset('/plugins/bootcomplete/bootcomplete.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/css/app/inicio.css') }}" rel="stylesheet">
@endsection

@section('navBarDropDowns')
    @if(isset($favorites))
        @include('app.comun.dropdowns.favorites')
    @endif
@endsection

@section('contentheader')
    <section class="content-header">

        <div class="menu-middle-top">
            <div class="mmt-finder">
                <div class="row">
                    <div class="col-sm-12 col-md-8 col-md-offset-2">
                        <div class="main-finder">
                            <div class="ctn-f">
                                <input type="text" id="finder_track" name="finderTrack"
                                       data-url="{{asset('estudios/audios/post/:id/track')}}"
                                       placeholder="&#xf002; Busqueda rapida..">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mmt-menu">
                <ul>
                    <li><a href="{{asset('all/audios')}}" class="active"><i class="ion ion-ios-list"></i> Todos</a></li>
                    <li><a href="{{asset('Predicación/audios')}}"><i class="ion ion-mic-c"></i> Predicaciónes</a></li>
                    <li><a href="{{asset('Estudio/audios')}}"><i class="ion ion-speakerphone"></i> Estudios</a></li>
                    <li><a href="{{asset('Serie/audios')}}"><i class="ion ion-disc"></i> Series</a></li>
                </ul>
            </div>
        </div>

    </section>
@endsection

@section('content')
    <input type="hidden" id="hdn_currentPage" value="2">
    <div class="track-box-container" data-lastp="{{$audios->lastPage()}}">
        @include('app.estudios.audios.box_track')
    </div>
    @include('app.comun.modals.share_modal')
@endsection

@section('scriptsapp')
    <script type="text/javascript">
        $(function () {
            $('.example').barrating({
                theme: 'fontawesome-stars'
            });
        });
    </script>
    <script src="{{asset('/plugins/jquery-md5/jquery-md5.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('/plugins/bootcomplete/jquery.bootcomplete.js') }}" type="text/javascript"></script>
    <script src="{{asset('/js/app/estudios/audios/Audio.js')}}" type="text/javascript"></script>
    <script src="{{asset('/js/app/estudios/audios/AudioService.js')}}" type="text/javascript"></script>
@endsection