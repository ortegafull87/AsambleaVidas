@extends('layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.titlepagemoTracks') }} | ADM
@endsection

@section('contentheader_title')
{{ trans('adminlte_lang::message.titlesectionmoTracks') }}
@endsection

@section('contentheader_description')
{{ trans('adminlte_lang::message.descrpsectionmoTracks') }}
@endsection

@section('heather_level')
<li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>Administrador</a></li>
<li class="active">Pistas</li>
@endsection

@section('main-content')

<div class="row">
	<div class="col-md-12">
		<div class="box" >
			<div class="box-header with-border text-center">
				<h3 class="box-title"></h3>
				@if($pistas->total() > 10)
				<div class="info-pagination pull-left">
					{{trans('adminlte_lang::message.page')}}: 	{{$pistas->currentPage()}} 
					{{trans('adminlte_lang::message.of')}} 		{{$pistas->lastPage()}} 
				</div>
				{{$pistas->total()}} {{trans('adminlte_lang::message.total')}}
				@else
				<div class="info-pagination">
					{{$pistas->total()}} {{trans('adminlte_lang::message.total')}}
				</div>
				@endif
				<div class="box-tools pull-right">
					<div class="btn-group">
						<button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" title="Eliminar">
							<i class="fa fa-times-circle fa-lg"></i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#" data-action="delete-some-track">{{trans('adminlte_lang::message.deleteSomeTrack')}}</a></li>
							<li><a href="#" data-action="delete-all-track">{{trans('adminlte_lang::message.deleAllTracks')}}</a></li>
						</ul>
					</div>

				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding" id="cont_tracks">
				@if (count($pistas))
				<table class="table table-hover">
					<thead>
						<tr>
							<td></td>
							<td>Id</td>
							<td>Pista</td>
							<td>Título</td>
							<td>Autor</td>
							<td>Album</td>
							<td>Creada</td>
							<td>Modificada</td>
							<td></td>

						</tr>
					</thead>
					<tbody>
						@foreach ($pistas as $pista)
						<tr>
							<td><input type="checkbox" name="tracks" id='trk_{{$pista->id}}'></td>
							<td>{{$pista->id}}</td>
							<td><a id="trk_{{$pista->id}}" class="audio {skin:'blue', animate:true, width:'0', volume:0.8, autoplay:false, loop:false, showVolumeLevel:false, showTime:false, allowMute:true, showRew:false, addGradientOverlay:false, downloadable:false, downloadablesecurity:false, id3: false}" href="{{ url($paht.'/'.$pista->folder.'/'.$pista->file) }}">{{$pista->title}}</a>
							</td>
							<td>{{ $pista->title }}</td>
							<td>{{ $pista->firstName}} {{ $pista->lastName}}</td>
							<td>{{ $pista->titleAlbume}}</td>
							<td>{{ $pista->created_at }}</td>
							<td>{{ $pista->updated_at }}</td>
							<td><a href="tracks/{{$pista->id}}/edit" id="trk_edit_{{$pista->id}}"><i class="fa fa-edit fa-lg" aria-hidden="true" title="Editar"></i></a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@else
				<h1>No hay registros</h1>
				@endif
			</div><!-- ./box-body -->
			@if($pistas->total() > 10)
			<div class="box-footer text-center">
				{{ $pistas->links() }}
			</div>
			@endif
		</div>
	</div>
</div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection
@section('view.scripts')
<script src="{{ asset('/js/admin/Track.js') }}" type="text/javascript"></script>
@endsection