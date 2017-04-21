<table class="table no-margin post-audio-info">
    <thead>
    <tr>
        <th colspan="3">
            <div class="row">
                <div class="col-xs-5 text-right">
                    <a href="#"><i class="ion-android-share-alt" aria-hidden="true"></i>
                        Compartir</a>
                </div>
                <div class="col-xs-5 text-right">
                    @if(empty($audio->remote_repository))
                        <a href="#"><i
                                    class="ion-android-download" aria-hidden="true"></i>
                            Descargar</a>
                    @else
                        <a href="{{env('URL_GOOGLE_REPOSITORY').'='.explode('=',$audio->remote_repository)[1]}}"
                           target="_blank"><i
                                    class="ion-android-download" aria-hidden="true"></i>
                            Descargar</a>
                    @endif
                </div>
            </div>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="3">
            <div class="cont-audio">
                <audio controls id="{{$audio->id}}"
                       data-url="{{asset('estudios/audios/'.$audio->id.'/setListened')}}">(
                    <source src="{{asset('/'.env('URL_BASE_AUDIOFILES').'/'.$audio->albume_folder.'/'.$audio->file)}}"
                            type="audio/mpeg">
                    Tu navegador no soporta elementos de audio.
                </audio>
            </div>
        </td>
    </tr>
    <tr>
        <td><span class="ion-mic-a" aria-hidden="true"></span></td>
        <td> Autor:</td>
        <td>{{$audio->author_firstName.' '.$audio->author_lastName}}</td>
    </tr>
    <tr>
        <td><span class="ion-folder" aria-hidden="true"></span></td>
        <td> Albume:</td>
        <td>{{$audio->albume_title}}</td>
    </tr>
    <tr>
        <td><span class="ion-disc" aria-hidden="true"></span></td>
        <td> Genero</td>
        <td>{{$audio->albume_genre}}</td>
    </tr>
    <tr>
        <td><span class="ion-ios-calendar" aria-hidden="true"></span></td>
        <td> Creado:</td>
        <td>{{\App\Library\Util::FORMAT_DATE_TO($audio->created_at,'d/m/Y H:i:s')}}</td>
    </tr>
    <tr>
        <td><span class="ion-compose" aria-hidden="true"></span></td>
        <td> Modificado:</td>
        <td>{{\App\Library\Util::FORMAT_DATE_TO($audio->updated_at,'d/m/Y H:i:s')}}</td>
    </tr>
    <tr>
        <td><span class="ion-radio-waves" aria-hidden="true"></span></td>
        <td> Reproduciones:</td>
        <td>{{$audio->listeneds}}</td>
    </tr>
    <tr>
        <td><span class="ion-chatbubbles" aria-hidden="true"></span></td>
        <td> Comentarios:</td>
        <td>{{$audio->posted}}</td>
    </tr>
    <tr>
        <td><span class="ion-ribbon-b" aria-hidden="true"></span></td>
        <td> Calificaci&oacute;n:</td>
        <td>
            <div class="rate"
                 data-url="{{asset('/estudios/audios/'.$audio->id.'/:rate/setRate')}}"
                 data-titulo="{{$audio->title}}" title="Calificar">
                @include('app.estudios.audios.rate_track')
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="toggle-favorite" data-url="{{asset('estudios/audios/'.$audio->id.'/toggleFavorite')}}"
                 data-titulo="{{$audio->title}}" title="Agregar a mis favoritos">
                @if($audio->favorite == 3)
                    <i class="fa fa-heart favorite" aria-hidden="true" style="cursor: pointer"></i>
                @else
                    <i class="fa fa-heart " aria-hidden="true" style="cursor: pointer"></i>
                @endif
            </div>
        </td>
        <td>
            Favorito
        </td>
        <td>
            <span class="tell-favorite">
            @if($audio->favorite == 3)
                    si
                @else
                    no
                @endif
            </span>
        </td>
    </tr>
    </tbody>
</table>