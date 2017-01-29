@foreach($audios as $audio)
    <div id="box_{{$audio->id}}" class="box">
        <div class="more-info text-right" data-toggle="tooltip" data-placement="right" title="Más información.">
            <i class="fa fa-info-circle fa"></i>
        </div>
        <div class="flag" data-url="{{asset('estudios/audios/'.$audio->id.'/toggleFavorite')}}"
             data-titulo="{{$audio->title}}" title="Agregar a mis favoritos">
            @if($audio->favorite == 3)
                <i class="fa fa-heart fa-2x favorite" aria-hidden="true"></i>
            @else
                <i class="fa fa-heart fa-2x" aria-hidden="true"></i>
            @endif
        </div>
        <div class="box-top"
             style="background-image: url('{{asset('img/app/tracks/Template-Pista-Vivelatorah.png')}}')">
        </div>
        <div class="box-content">
            <div class="title" title="{{$audio->title}}">
                <label title="Super Title">{{$audio->title}}</label>
            </div>
            <div class="data">
                <div class="rate" data-url="{{asset('/estudios/audios/'.$audio->id.'/:rate/setRate')}}"
                     data-titulo="{{$audio->title}}" title="Calificar">
                    @include('app.estudios.audios.rate_track')
                </div>
                <div class="author" title="Autor:  {{$audio->author_firstName.' '.$audio->author_lastName}}">
                    <span class="fa fa-microphone"></span>
                    {{str_limit($audio->author_firstName.' '.$audio->author_lastName,37)}}
                </div>
            </div>
            <div class="sinapsis">
                @if(strlen($audio->description)>0)
                    <?php echo str_limit($audio->description,215)?>
                    @if(strlen($audio->description)>215)
                        <a href="{{asset('estudios/audios/post/'.$audio->id.'/track')}}">Seguir leyendo</a>
                    @endif
                @else
                    @include('app.comun.no-content-message')
                @endif
            </div>
            <div class="controls">
                <audio controls id="{{$audio->id}}" data-url="{{asset('estudios/audios/'.$audio->id.'/setListened')}}">(
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
                    <a id="{{$audio->id}}" name="share" href="#" title="Compartir">
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
                    <a href="#" title="Descargar">
                        <i class="fa fa-cloud-download" aria-hidden="true"></i>
                        Descargar
                    </a>
                </div>
            </div>
        </div>
        <div class="option-share">
            <span class="fa fa-times" title="Cerrar"></span>
            <div class="option"><a href="#"><span class="fa fa-envelope"></span> correo</a></div>
            <div class="option"><a href="#"><span class="fa fa-facebook"></span> facebook</a></div>
            <div class="option"><a href="#"><span class="fa fa-twitter"></span> twitter</a></div>
        </div>
    </div>
@endforeach
