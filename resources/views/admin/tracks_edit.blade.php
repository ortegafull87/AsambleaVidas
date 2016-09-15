@extends('layouts.app')

@section('htmlheader_title')
Editar {{ trans('adminlte_lang::message.titlepagemoTracks') }} | ADM
@endsection

@section('contentheader_title')
{{ trans('adminlte_lang::message.titleAdmEditTrack') }}
@endsection

@section('contentheader_description')
{{ trans('adminlte_lang::message.descriptionAdmEditTrack') }}
@endsection

@section('heather_level')
<li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>Administrador</a></li>
<li><a href="{{url('admin/tracks')}}"><i class="fa fa-dashboard"></i>Pistas</a></li>
<li class="active">Edici&oacute;n</li>
@endsection

@section('main-content')

<div class="row">
	<form id="edit" action="{{ url('/admin/tracks/'.$pistas[0]->id) }}" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
		<input type="hidden" name="_method" value="PATCH">
		<div class="col-sm-1 col-md-3"></div>
		<div class="col-sm-10 col-md-6">
			<div class="box" >
				<div class="box-header with-border">
					<h3 class="box-title"></h3>
					<div class="box-tools pull-right">
						<div class="btn-group">
							<button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-eraser"></i>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a href="#" data-action="clear-form-new-track">{{trans('adminlte_lang::message.clearFormNewTrack')}}</a></li>
							</ul>
						</div>
					</div>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-music"></i></span>
						<input class="form-control" placeholder="titulo" type="text" name="trk_titulo" value="{{$pistas[0]->title}}" required>
					</div>
					<br>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa  fa-user"></i></span>
							<select class="form-control" name="trk_author" required>
								@foreach ($authors as $author)
								<option 
								value="{{$author->id}}"
								@if ($author->id == $pistas[0]->idAuthor) 
								selected 
								@endif
								>
								{{$author->firstName}} {{$author->lastName}}
							</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-folder"></i></span>
						<select class="form-control" name="trk_albume" required>
							@foreach ($albumes as $albume)
							<option 
							value="{{$albume->id}}" 
							@if ($albume->id == $pistas[0]->idAlbume) 
							selected 
							@endif >
							{{$albume->title}}
						</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">{{ trans('adminlte_lang::message.actualTrackAdmEditTrack') }}</label>
				<a class="audio {skin:'blue', animate:true, width:'100%', volume:0.8, autoplay:false, loop:false}" href="{{ url($pistas[0]->file) }}">{{$pistas[0]->title}}</a>
			</div>
			<div class="form-group">
				<span class="label label-default">{{ trans('adminlte_lang::message.msjRequirimentAdmEditTrack') }}</span>
			</div>

			<div class="form-group">
				<div class="browse-wrap">
					<div class="title"><i class="fa fa-cloud-upload fa-3x" aria-hidden="true"></i></div>
					<span class="upload-path"></span>
					<input type="hidden" name="MAX_FILE_SIZE" = value="45000000">
					<input type="file" name="file" class="upload" title="Choose a file to upload">
				</div>
			</div>
		</div>

		<!-- ./box-body -->
		<div class="box-footer form-inline">
			<div class="row">
				<div class="col-sm-12">
					<div class="progress active" id="pg_bar_track">
						<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
							<span class="sr-only"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<button id="btn_cancelar" type="button" class="btn btn-block btn-default">{{ trans('adminlte_lang::message.btnCancelarAdm') }}</button>
					<button id="btn_regresar" type="button" class="btn btn-block btn-default">{{ trans('adminlte_lang::message.btnRegresarAdm') }}</button>
				</div>
				<div class="col-sm-6">
					<button id="btn_submit_update" type="submit" form="edit" class="btn btn-block btn-primary">{{ trans('adminlte_lang::message.btnActualizarAdm') }}</button>
				</div>
			</div>
		</form>
	</div><!-- /.row -->
</div>
<div class="col-sm-1 col-md-3"></div>
</div>
@endsection

@section('view.scripts')
<!-- script file here -->
<script src="{{ asset('/js/admin/EditTrack.js') }}" type="text/javascript"></script>
@endsection