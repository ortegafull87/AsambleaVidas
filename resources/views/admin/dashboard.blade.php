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
<li><a href="#"><i class="fa fa-dashboard"></i>Administrador</a></li>
<li class="active">Dashboard</li>
@endsection

@section('main-content')

<h1>Dashboard</h1>

@endsection
@section('view.scripts')
<script src="{{ asset('/js/admin/Dashboard.js') }}" type="text/javascript"></script>
@endsection