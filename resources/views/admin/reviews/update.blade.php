@extends('layouts.admin')

@section('htmlheader_title')
    Revista - {{$pistas[0]->title}}| ADM
@endsection

@section('contentheader_title')
    {{$pistas[0]->title}}.
@endsection

@section('contentheader_description')
    Revista de contenido.
@endsection

@section('heather_level')
    <li><a href="{{url('admin/dashboard')}}"><i class="fa fa-dashboard"></i>Administrador</a></li>
    <li><a href="{{asset('admin/review')}}"><i class="fa fa-eye"></i>Revista</a></li>
    <li class="active"><i class="fa fa-music"></i> {{$pistas[0]->title}}</li>
@endsection

@section('main-content')
    <style>
        .products-list .product-info {
            margin-left: 5px;
        }

        .products-list .product-info span {
            margin-right: 5px;
        }
    </style>
    <div class="row">
        <div class="col-md-3">
            <button class="btn btn-block btn-primary btn-flat" id="btn_actualizar" data-url="{{asset('/admin/review/'.$pistas[0]->id.'/update')}}">
                <span class="">Actualizar</span>
                <i class="fa fa-refresh fa-spin fa-fw hidden"></i>
            </button>
            <button class="btn btn-block btn-default btn-flat" id="btn_cancelar" data-url="{{asset('admin/review')}}">Cancelar</button>
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    @include('admin.reviews.form_track')
                </div><!-- ./box-body -->
            </div>
        </div>
    </div>
@endsection
@section('view.scripts')
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script src="{{ asset('/plugins/bootcomplete/jquery.bootcomplete.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/admin/Review.js') }}" type="text/javascript"></script>

    <script>
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('documentacion');
        });
    </script>
@endsection