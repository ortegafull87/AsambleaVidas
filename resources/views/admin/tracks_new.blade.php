@extends('layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.titlePageNewTrack') }} | ADM
@endsection

@section('contentheader_title')
{{ trans('adminlte_lang::message.titlePageNewTrack') }}
@endsection

@section('contentheader_description')
{{ trans('adminlte_lang::message.descriptionNewtrack') }}
@endsection

@section('heather_level')
<li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.administrator') }}</a></li>
<li><a href="{{url('admin/tracks')}}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.titlesectionmoTracks') }}</a></li>
<li class="active">{{ trans('adminlte_lang::message.titleNewTrack') }}
</li>
@endsection

@section('main-content')

<div class="row">

	<div class="col-sm-1 col-md-3"></div>
	<div class="col-sm-10 col-md-6">
		<div class="box" id="box_form_new_track">
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
				<form id='up' action="{{ url('/admin/tracks') }}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-music"></i></span>
						<input class="form-control" placeholder="titulo" type="text" name="trk_titulo" required>
					</div>
					<br>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa  fa-user"></i></span>
							<select class="form-control" name="trk_author" required>
								<option value="">Autor </option>
								@foreach ($authors as $author)
								<option value="{{$author->id}}">{{$author->firstName}} {{$author->lastName}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-folder"></i></span>
							<select class="form-control" name="trk_albume" required>
								<option value="">Albume </option>
								@foreach ($albumes as $albume)
								<option value="{{$albume->id}}">{{$albume->title}}</option>
								@endforeach
							</select>
						</div>
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
				</form>
			</div><!-- ./box-body -->
			<div class="box-footer">
				<div class="progress active" id="pg_bar_track">
					<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
						<span class="sr-only"></span>
					</div>
				</div>
				<span><i class="fa fa-close"></i></span>
				<button id="btn_submit_track" class="btn btn-block btn-primary btn-sm" type="submit" form="up"><i class="fa  fa-plus"></i> Registrar</button>
			</div><!-- /.box-footer -->
		</div>
	</div>
	<div class="col-sm-1 col-md-3"></div>
</div>
</div><!-- end row -->

@endsection
@section('view.scripts')
<!-- script file here -->
<script src="{{ asset('/js/admin/NewTrack.js') }}" type="text/javascript"></script>
@endsection
