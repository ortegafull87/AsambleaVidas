@if(count($audios) > 0)
    @foreach($audios as $audio)
        <div id="box_{{$audio->id}}" class="box">
            <div class="flag" data-url="{{asset('estudios/audios/'.$audio->id.'/toggleFavorite')}}"
                 data-titulo="{{$audio->title}}" title="Agregar a mis favoritos">
                @if($audio->favorite == 3)
                    <i class="fa fa-heart fa-2x favorite" aria-hidden="true"></i>
                @else
                    <i class="fa fa-heart fa-2x" aria-hidden="true"></i>
                @endif
            </div>
        @if(empty($audio->albume_picture))
            <!--<div class="box-top" style="background-image: url('https://images.alphacoders.com/689/thumb-350-689704.jpg')"></div>-->
                <div class="box-top"
                     style="background-image: url('{{asset(env('URL_BASE_ALBUMES').'default.jpg')}}'); background-size: cover;"></div>
            @else
                <div class="box-top"
                     style="background-image: url('{{asset(env('URL_BASE_ALBUMES').$audio->albume_picture)}}');background-size: cover;"></div>
            @endif
            <div class="box-content">
                <div class="title text-ovweflow" title="{{$audio->title}}">
                    <label title="Super Title">
                        <a href="{{asset('estudios/audios/post/'.$audio->id.'/track')}}"
                           class="app-link">{{$audio->title}}</a>
                    </label>
                </div>
                <div class="data">
                    <div class="rate" data-url="{{asset('/estudios/audios/'.$audio->id.'/:rate/setRate')}}"
                         data-titulo="{{$audio->title}}" title="Calificar">
                        @include('app.estudios.audios.rate_track')
                    </div>
                    <div class="author text-ovweflow" title="Autor:  {{$audio->author_firstName.' '.$audio->author_lastName}}">
                        <span class="fa fa-microphone"></span>
                        {{str_limit($audio->author_firstName.' '.$audio->author_lastName,37)}}
                    </div>
                </div>
                <div class="sinapsis">
                    @if(strlen($audio->description)>0)
                        <?php echo $audio->sketch?>
                        @if(strlen($audio->sketch)>215)
                            <a href="{{asset('estudios/audios/post/'.$audio->id.'/track')}}" class="app-link">Seguir
                                leyendo</a>
                        @endif
                    @else
                        @include('app.comun.no-content-message')
                    @endif
                </div>
                <div class="controls">
                    <audio controls id="{{$audio->id}}"
                           data-url="{{asset('estudios/audios/'.$audio->id.'/setListened')}}">(
                        <source src="{{asset('/'.env('URL_BASE_AUDIOFILES').'/'.$audio->albume_folder.'/'.$audio->file)}}"
                                type="audio/mpeg">
                        Tu navegador no soporta elementos de audio.
                    </audio>
                </div>
                <div class="score">
                    @if($audio->listeneds)
                        <span class="playeds">{{$audio->listeneds}}</span>
                        <span>Reproducciones</span>
                    @else
                        <span>Se el primero en escucharla</span>
                    @endif
                    @if($audio->posted > 0)
                        <div class="comments text-right pull-right">
                            <a href="{{asset('estudios/audios/post/'.$audio->id.'/track')}}" title="Comentarios">
                                <i class="fa fa-comments-o"></i>
                                <label> {{$audio->posted}}</label>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="box-footer">
                <div class="share">
                    <div>
                        <a data-action="share" data-id="{{$audio->id}}" href="#" title="Compartir">
                            <i class="fa fa-share-alt" aria-hidden="true"></i>
                            Compartir
                        </a>
                    </div>
                    <div>
                        <!--<a href="" title="Me gusta">
                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                            Me gusta
                        </a>-->
                    </div>
                    <div>
                        @if(empty($audio->remote_repository))
                            <a href="#" title="Descargar">
                                <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                Descargar
                            </a>
                        @else
                            <a href="{{env('URL_GOOGLE_REPOSITORY').'='.explode('=',$audio->remote_repository)[1]}}"
                               title="Descargar" target="_blank">
                                <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                Descargar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    @include('app.comun.no-content-message')
@endif