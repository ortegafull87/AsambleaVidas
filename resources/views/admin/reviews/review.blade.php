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
            <button class="btn btn-block btn-success btn-flat">Autorizar</button>
            <button class="btn btn-block btn-default btn-flat" id="btn_cancelar" data-url="{{asset('admin/review')}}">Cancelar</button>
        </div>
        <div class="col-md-9">
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-music"></i></span>
                        <input class="form-control" placeholder="titulo" type="text" name="trk_titulo"
                               value="{{$pistas[0]->title}}" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa  fa-user"></i></span>
                            <input class="form-control" placeholder="Autor"
                                   value="{{$pistas[0]->firstName .' '. $pistas[0]->lastName}}" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-folder"></i></span>
                            <input class="form-control" placeholder="Albume" value="{{$pistas[0]->titleAlbume}}"
                                   disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                            <input class="form-control" placeholder="Genero" value="{{$pistas[0]->genre}}"
                                   disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Reseña</label>
                        <textarea class="form-control" rows="3" name="trk_sketch" placeholder="Ingrese una breve reseña">
                            {{$pistas[0]->sketch}}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>Documentaci&oacute;n</label>
                    <textarea id="editor1" name="editor1" rows="50" cols="80"
                              style="visibility: hidden; display: none;">
                        <?php echo $pistas[0]->description?>
                    </textarea>
                    </div>
                </div><!-- ./box-body -->
            </div>
        </div>
    </div>
@endsection
@section('view.scripts')
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script src="{{ asset('/js/admin/Review.js') }}" type="text/javascript"></script>

    <script>
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor1');
        });
    </script>
@endsection