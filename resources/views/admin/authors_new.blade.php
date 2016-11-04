@extends('layouts.app')

@section('htmlheader_title')
{{ trans('adminlte_lang::message.titlePageNewAuthor') }} | ADM
@endsection

@section('contentheader_title')
{{ trans('adminlte_lang::message.titlePageNewAuthor') }}
@endsection

@section('contentheader_description')
{{ trans('adminlte_lang::message.titleDescriptionPageNewAuthor') }}
@endsection

@section('heather_level')
<li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.administrator') }}</a></li>
<li><a href="{{url('admin/authors')}}"><i class="fa fa-paint-brush"></i>{{ trans('adminlte_lang::message.moduleNameAuthor') }}</a></li>
<li class="active">{{ trans('adminlte_lang::message.sectionNameNewAuthor') }}
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
							<li><a href="#" data-action="clear-form">{{trans('adminlte_lang::message.clearFormNewTrack')}}</a></li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<form id='new_author' action="{{ url('/admin/authors') }}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input class="form-control" placeholder="Nombre (s)" type="text" name="nombre" required>
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input class="form-control" placeholder="Apellido (s)" type="text" name="apellidos" required>
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon"><i>@</i></span>
						<input class="form-control" placeholder="e-mail 1" type="email" name="email1" required>
					</div>
					<br>
					<div class="input-group">
						<span class="input-group-addon"><i>@</i></span>
						<input class="form-control" placeholder="e-mail 2" type="email" name="email2" required>
					</div>
				</form>
			</div><!-- ./box-body -->
			<div class="box-footer">
				<button id="btn_submit_track" class="btn btn-block btn-primary btn-sm" type="submit" form="new_author"><i class="fa  fa-plus"></i> Registrar</button>
			</div><!-- /.box-footer -->
		</div>
	</div>
	<div class="col-sm-1 col-md-3"></div>
</div>
</div><!-- end row -->

@endsection
@section('view.scripts')
<!-- script file here -->
<script src="{{ asset('/js/admin/NewAuthor.js') }}" type="text/javascript"></script>
@endsection
