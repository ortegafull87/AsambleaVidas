@extends('layouts.admin')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.titlePageEditAlbume') }} | ADM
@endsection

@section('contentheader_title')
    {{ trans('adminlte_lang::message.titlePageEditAlbume') }}
@endsection

@section('contentheader_description')
    {{ trans('adminlte_lang::message.titleDescriptionEditAlbume') }}
@endsection

@section('heather_level')
    <li><a href="{{url('admin/dashboard')}}"><i
                    class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.administrator') }}</a></li>
    <li><a href="{{url('admin/albumes')}}"><i
                    class="fa fa-folder-open"></i>{{ trans('adminlte_lang::message.moduleNameAlbume') }}</a></li>
    <li class="active">{{ trans('adminlte_lang::message.sectionNameAlbume') }}
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
                                <i class="fa fa-mail-reply"></i>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"
                                       data-action="clear-form">{{trans('adminlte_lang::message.revertchanges')}}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form id='edit_albume' action="{{ url('/admin/albumes/'.$albume[0]->id) }}" method="post"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-folder-open"></i></span>
                            <input class="form-control" placeholder="Titulo" type="text" name="title"
                                   value="{{$albume[0]->title}}" required>
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-simplybuilt"></i></span>
                            <select class="form-control" name="genre" required>
                                <option value="">Genero</option>
                                @foreach ($generos as $genero)
                                    <option
                                            value="{{$genero['genre']}}"
                                            @if ($albume[0]->genre == $genero['genre'])
                                            selected
                                            @endif >
                                        {{$genero['genre']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-image-o"></i></span>
                            <input class="form-control" placeholder="Puede agregar una imagen" type="file" name="picture">
                        </div>
                        <br>
                        <div class="input-group max-width">
                            <textarea id="alb_description" class="max-width">
                                {{$albume[0]->description}}
                            </textarea>
                        </div>
                    </form>
                </div><!-- ./box-body -->
                <div class="box-footer">
                    <div class="col-md-6">
                        <button id="btn_cancelar" type="button"
                                class="btn btn-block btn-default">{{ trans('adminlte_lang::message.btnCancelarAdm') }}</button>
                        <button id="btn_regresar" type="button"
                                class="btn btn-block btn-default">{{ trans('adminlte_lang::message.btnRegresarAdm') }}</button>
                    </div>
                    <div class="col-md-6">
                        <button id="btn_submit_track" class="btn btn-block btn-primary" type="submit"
                                form="edit_albume"><i
                                    class=""></i> {{ trans('adminlte_lang::message.btnActualizarAdm') }}</button>
                    </div>
                </div><!-- /.box-footer -->
            </div>
        </div>
        <div class="col-sm-1 col-md-2"></div>
    </div>
    </div><!-- end row -->

@endsection
@section('view.scripts')
    <!-- script file here -->
    <script src="{{ asset('/js/admin/EditAlbume.js') }}" type="text/javascript"></script>
@endsection
