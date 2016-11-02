@extends('layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.titlePageEditAuthor') }} | ADM
@endsection

@section('contentheader_title')
{{ trans('adminlte_lang::message.titlePageEditAuthor') }}
@endsection

@section('contentheader_description')
{{ trans('adminlte_lang::message.titleDescriptionEditAuthor') }}
@endsection

@section('heather_level')
<li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i></a>{{trans('adminlte_lang::message.administrator')}}</li>
<li><a href="{{url('admin/authors')}}"><i class="fa fa-paint-brush"></i>{{trans('adminlte_lang::message.moduleNameAuthor')}}</a></li>
<li class="active">{{trans('adminlte_lang::message.sectionNameAuthor')}}
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
							<i class="fa fa-mail-reply"></i>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#" data-action="clear-form">{{trans('adminlte_lang::message.revertchanges')}}</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<form id='edit_author' action="{{ url('/admin/authors/'.$authors[0]->id) }}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input class="form-control" placeholder="Nombre" type="text" name="nombre" value="{{$authors[0]->firstName}}" required>
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input class="form-control" placeholder="Apellidos" type="text" name="apellidos" value="{{$authors[0]->lastName}}" required>
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon"><i>@</i></span>
						<input class="form-control" placeholder="e-mail" type="email" name="email" required>
					</div>
				</form>
			</div><!-- ./box-body -->
			<div class="box-footer">
			<div class="row">
				<div class="col-md-6">
					<button id="btn_cancelar" type="button" class="btn btn-block btn-default">{{ trans('adminlte_lang::message.btnCancelarAdm') }}</button>
					<button id="btn_regresar" type="button" class="btn btn-block btn-default">{{ trans('adminlte_lang::message.btnRegresarAdm') }}</button>
				</div>
				<div class="col-md-6">
					<button id="btn_submit_track" class="btn btn-block btn-primary" type="submit" form="edit_author"><i class=""></i> {{ trans('adminlte_lang::message.btnActualizarAdm') }}</button>
				</div>
			</div>
			</div><!-- /.box-footer -->
		</div>
	</div>
	<div class="col-sm-1 col-md-3"></div>
</div>
</div><!-- end row -->

@endsection
@section('view.scripts')
<!-- script file here -->
<script src="{{ asset('/js/admin/EditAuthor.js') }}" type="text/javascript"></script>
@endsection
