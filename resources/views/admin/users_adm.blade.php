@extends('layouts.admin')

@section('htmlheader_title')
    {{trans('adminlte_lang::message.titlePageUserRegistered')}} | ADM
@endsection

@section('contentheader_title')
    {{trans('adminlte_lang::message.titlePageUserRegistered')}}
@endsection

@section('contentheader_description')
    {{trans('adminlte_lang::message.titleDescriptionPageUserRegistered')}}
@endsection

@section('heather_level')
    <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>{{trans('adminlte_lang::message.administrator')}}</a></li>
    <li class="active">{{trans('adminlte_lang::message.moduleNameUser')}}</li>
@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-12">
            <div class="box" id="box_list_users">
                @include('admin.partials.list_users')
            </div>
        </div>
    </div>
    <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
@endsection
@section('view.scripts')
    <script src="<?php echo e(asset('/js/admin/User.js').'?v='. env('APP_VERSION')); ?>" type="text/javascript"></script>
@endsection