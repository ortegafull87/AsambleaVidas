@extends('layouts.app')

@section('htmlheader_title')
{{trans('adminlte_lang::message.titlePageAlbumesRegistered')}} | ADM
@endsection

@section('contentheader_title')
{{trans('adminlte_lang::message.titlePageAlbumesRegistered')}}
@endsection

@section('contentheader_description')
{{trans('adminlte_lang::message.titleDescriptionPageAlbumesRegistered')}}
@endsection

@section('heather_level')
<li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>{{trans('adminlte_lang::message.administrator')}}</a></li>
<li class="active"><i class="fa fa-folder-open"></i> {{trans('adminlte_lang::message.moduleNameAlbume')}}</li>
@endsection

@section('main-content')

<div class="row">
	<div class="col-md-12">
		<div class="box" id="box_list_albumes">
			@include('admin.partials.list_albumes')
		</div>
	</div>
</div>
<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
@endsection
@section('view.scripts')
<script src="{{asset('/js/admin/Albume.js')}}" type="text/javascript"></script>
@endsection