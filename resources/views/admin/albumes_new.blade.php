@extends('layouts.admin')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.titlePageNewAlbume') }} | ADM
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.titlePageNewAlbume') }}
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::message.titleDescriptionPageNewAlbum') }}
@endsection

@section('heather_level')
    <li><a href="{{url('admin/dashboard')}}"><i
                    class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.administrator') }}</a></li>
    <li><a href="{{url('admin/albumes')}}"><i
                    class="fa fa-folder-open"></i>{{ trans('adminlte_lang::message.moduleNameAlbume') }}</a></li>
    <li class="active">{{ trans('adminlte_lang::message.sectionNameNewAlbume') }}
    </li>
@endsection

@section('main-content')

    <div class="row">

        <div class="col-sm-1 col-md-2"></div>
        <div class="col-sm-10 col-md-8">
            <div class="box" id="box_form_new_track">
                <div class="box-header with-border">
                    <h3 class="box-title"></h3>
                    <div class="box-tools pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-eraser"></i>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"
                                       data-action="clear-form">{{trans('adminlte_lang::message.clearFormNewTrack')}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form id='new_albume' action="{{ url('/admin/albumes') }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-folder-open"></i></span>
                            <input class="form-control" placeholder="Titulo" type="text" name="title" required>
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-simplybuilt"></i></span>
                            <select class="form-control" name="genre" required>
                                <option value="">G&eacute;nero</option>
                                @foreach ($generos as $genero)
                                    <option value="{{$genero['genre']}}">{{$genero['genre']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-image-o"></i></span>
                            <input class="form-control" type="file" name="picture" id="picture">
                        </div>
                        <br>
                        <div class="input-group max-width">
                            <textarea id="alb_description" class="max-width"></textarea>
                        </div>
                    </form>
                </div><!-- ./box-body -->
                <div class="box-footer">
                    <button id="btn_submit_track" class="btn btn-block btn-primary btn-sm" type="submit"
                            form="new_albume"><i class="fa  fa-plus"></i> Registrar
                    </button>
                </div><!-- /.box-footer -->
            </div>
        </div>
        <div class="col-sm-1 col-md-2"></div>
    </div>
    </div><!-- end row -->

@endsection
@section('view.scripts')
    <!-- script file here -->
    <script src="{{ asset('/js/admin/NewAlbume.js') }}" type="text/javascript"></script>
@endsection
