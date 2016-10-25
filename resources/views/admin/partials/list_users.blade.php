<div class="box-header with-border text-center">
    <h3 class="box-title"></h3>
    @if($users->total() > 10)
        <div class="info-pagination pull-left">
            {{trans('adminlte_lang::message.page')}}: {{$users->currentPage()}}
            {{trans('adminlte_lang::message.of')}}        {{$users->lastPage()}}
        </div>
        {{$users->total()}} {{trans('adminlte_lang::message.total')}}
    @else
        <div class="info-pagination">
            {{$users->total()}} {{trans('adminlte_lang::message.total')}}
        </div>
    @endif
    <div class="box-tools pull-right">

    </div>
</div>
<!-- /.box-header -->
<div class="box-body table-responsive no-padding" id="cont">
    @if (count($users))
        <table class="table table-hover">
            <thead>
            <tr>
                <td>No.</td>
                <td>Nombre</td>
                <td>E-mail</td>
                <td>Contraseña</td>
                <td>Privilegio</td>
                <td>Creado</td>
                <td>Modificado</td>
                <td>Estatus</td>
                @if(App\Library\Util::AUNTH_USER_ROOT())
                    <td class="text-center text-blue">Baja/Alta</td>
                @endif

            </tr>
            </thead>
            <tbody>
            <?php $iter = 1 ?>
            @foreach ($users as $user)
                <tr id="user_{{$user->id}}">
                    <td>{{$iter++}}</td>
                    <td>{{$user->name}} </td>
                    <td>{{$user->email}}</td>
                    <td>{{substr($user->password,0,15)}}...</td>
                    <td>{{$user->description}}</td>
                    <td>{{$user->created_at}}</td>
                    <td>{{$user->updated_at}}</td>
                    <td>{{$user->status}}</td>
                    @if(App\Library\Util::AUNTH_USER_ROOT())
                        <td class="text-center">
                            <a href="{{ url('/admin/users/'.$user->id) }}" id="{{$user->id}}"
                               data-status="{{$user->status_id}}">
                                @if($user->status_id == 1)
                                    <i class="fa fa-thumbs-down fa-lg " aria-hidden="true" title="Dar de baja"></i>
                                @else
                                    <i class="fa fa-thumbs-up fa-lg " aria-hidden="true" title="Dar de alta"></i>
                                @endif
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h1>No hay registros</h1>
    @endif
</div><!-- ./box-body -->
@if($users->total() > 10)
    <div class="box-footer text-center">
        {{$users->links()}}
    </div>
@endif