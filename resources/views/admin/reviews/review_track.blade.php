<div class="box box-primary">
    <div class="box-header with-border text-center">
        <h3 class="box-title">Audios {{$nameFilter}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body " id="cont_tracks">
        @if(count($pistas) > 0)
            <div class="table-responsive">
                <table class="table table-striped" style="font-size: 0.86em;">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Audio</th>
                        <th>Autor</th>
                        <th>Albume</th>
                        <th>Genero</th>
                        <th>Modificado</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pistas as $index => $pista)
                        <tr data-id="{{$pista->id}}">
                            <td class="filterable-cell">{{++$index}}</td>
                            <td class="filterable-cell">{{$pista->title}}</td>
                            <td class="filterable-cell">{{$pista->firstName . ' ' . $pista->lastName }}</td>
                            <td class="filterable-cell">{{$pista->titleAlbume}}</td>
                            <td class="filterable-cell">{{$pista->genre}}</td>
                            <td class="filterable-cell">{{$pista->updated_at}}</td>
                            <td class="filterable-cell review_action">
                                @if($pista->status_id == 6)
                                    <button class="btn btn-block btn-primary btn-xs" data-action="revisar" data-url="{{asset('admin/review/'.$pista->id.'/track/to/autorize')}}">Revisar
                                    </button>
                                @elseif($pista->status_id == 4)
                                    <button class="btn btn-block btn-success btn-xs" data-action="activar">Activar
                                    </button>
                                @elseif($pista->status_id == 2)
                                    <button class="btn btn-block btn-primary btn-xs" data-action="revisar" data-url="{{asset('admin/review/'.$pista->id.'/track/to/autorize')}}">Revisar
                                    </button>
                                @elseif($pista->status_id == 1)
                                    <button class="btn btn-block btn-info btn-xs" data-action="actualizar" data-url="{{asset('admin/review/'.$pista->id.'/track/to/update')}}">Actualizar
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @include('app.comun.no-content-message')
        @endif
    </div><!-- ./box-body -->
    <div class="box-footer" style="min-height: 61px;">
        {{$pistas->links()}}
    </div>
</div>