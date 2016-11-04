<div class="box-header with-border text-center">
    <h3 class="box-title"></h3>
    @if($authors->total() > 10)
        <div class="info-pagination pull-left">
            {{trans('adminlte_lang::message.page')}}: {{$authors->currentPage()}}
            {{trans('adminlte_lang::message.of')}}        {{$authors->lastPage()}}
        </div>
        {{$authors->total()}} {{trans('adminlte_lang::message.total')}}
    @else
        <div class="info-pagination">
            {{$authors->total()}} {{trans('adminlte_lang::message.total')}}
        </div>
    @endif
    <div class="box-tools pull-right">
        <div class="btn-group">
            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" title="Eliminar">
                <i class="fa  fa-trash fa-lg"></i>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#"
                       data-action="delete-some-item">{{trans('adminlte_lang::message.deleteSelectedItems')}}</a></li>
                <li><a href="#" data-action="delete-all-items">{{trans('adminlte_lang::message.deleteAllItems')}}</a>
                </li>
            </ul>
        </div>

    </div>
</div>
<!-- /.box-header -->
<div class="box-body table-responsive no-padding" id="cont">
    @if (count($authors))
        <table class="table table-hover">
            <thead>
            <tr>
                <td></td>
                <td>No.</td>
                <td>Nombre</td>
                <td>Apellido</td>
                <td>Email 1</td>
                <td>Email 2</td>
                <td>Creada</td>
                <td>Modificada</td>
                <td></td>

            </tr>
            </thead>
            <tbody>
            <?php $iter = 1 ?>
            @foreach ($authors as $author)
                <tr>
                    <td><input type="checkbox" name="authors" id='athr_{{$author->id}}'></td>
                    <td>{{$iter++}}</td>
                    <td>{{$author->firstName}} </td>
                    <td>{{$author->lastName}}</td>
                    <td>{{$author->email1}}</td>
                    <td>{{$author->email2}}</td>
                    <td>{{$author->created_at}}</td>
                    <td>{{$author->updated_at}}</td>
                    <td><a href="authors/{{$author->id}}/edit" id="athr_edit_{{$author->id}}"><i
                                    class="fa fa-edit fa-lg" aria-hidden="true" title="Editar"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h1>No hay registros</h1>
    @endif
</div><!-- ./box-body -->
@if($authors->total() > 10)
    <div class="box-footer text-center">
        {{$authors->links()}}
    </div>
@endif