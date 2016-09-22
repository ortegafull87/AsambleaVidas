@extends('layouts.app')

@section('htmlheader_title')
{{trans('adminlte_lang::message.titlePageAuthorsRegistered')}} | ADM
@endsection

@section('contentheader_title')
{{trans('adminlte_lang::message.titlePageAuthorsRegistered')}}
@endsection

@section('contentheader_description')
{{trans('adminlte_lang::message.titleDescriptionPageAuthorsRegistered')}}
@endsection

@section('heather_level')
<li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>{{trans('adminlte_lang::message.administrator')}}</a></li>
<li class="active">{{trans('adminlte_lang::message.moduleNameAuthor')}}</li>
@endsection

@section('main-content')

<div class="row">
	<div class="col-md-12">
		<div class="box" id="box_list_authors">
			@include('admin.partials.list_authors')
		</div>
	</div>
</div>
<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
@endsection
@section('view.scripts')
<script src="{{asset('/js/admin/Author.js')}}" type="text/javascript"></script>
@endsection