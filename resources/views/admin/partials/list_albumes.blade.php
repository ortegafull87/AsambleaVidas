<div class="box-header with-border text-center">
	<h3 class="box-title"></h3>
	@if($albumes->total() > 10)
	<div class="info-pagination pull-left">
		{{trans('adminlte_lang::message.page')}}: 	{{$albumes->currentPage()}}
		{{trans('adminlte_lang::message.of')}} 		{{$albumes->lastPage()}}
	</div>
	{{$albumes->total()}} {{trans('adminlte_lang::message.total')}}
	@else
	<div class="info-pagination">
		{{$albumes->total()}} {{trans('adminlte_lang::message.total')}}
	</div>
	@endif
	<div class="box-tools pull-right">
		<div class="btn-group">
			<button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" title="Eliminar">
				<i class="fa  fa-trash fa-lg"></i>
			</button>
			<ul class="dropdown-menu" role="menu">
				<li><a href="#" data-action="delete-some-item">{{trans('adminlte_lang::message.deleteSelectedItems')}}</a></li>
				<li><a href="#" data-action="delete-all-items">{{trans('adminlte_lang::message.deleteAllItems')}}</a></li>
			</ul>
		</div>

	</div>
</div>
<!-- /.box-header -->
<div class="box-body table-responsive no-padding" id="cont">
	@if (count($albumes))
	<table class="table table-hover">
		<thead>
			<tr>
				<td></td>
				<td>No.</td>
				<td>T&iacute;tulo</td>
				<td>G&eacute;nero</td>
				<td class="text-center">Descripción</td>
				<td>Creado</td>
				<td>Modificado</td>
				<td></td>

			</tr>
		</thead>
		<tbody>
			<?php $iter=1 ?>
			@foreach ($albumes as $albume)
			<tr>
				<td><input type="checkbox" name="albumes" id='athr_{{$albume->id}}'></td>
				<td>{{$iter++}}</td>
				<td>{{$albume->title}} </td>
				<td>{{$albume->genre}}</td>
					@if($albume->description != "" )
						<td class="popover-description c-pointer text-center" cdata-title="{{$albume->title}}" data-description="{{$albume->description}}">
							<div class="fa fa-info-circle max-width"></div>
						</td>
					@else
						<td class="popover-description c-pointer text-center" data-title="{{$albume->title}}" data-description="Sin descripción">
							<div class="fa fa-exclamation max-width"></div>
						</td>
					@endif
				<td>{{$albume->created_at}}</td>
				<td>{{$albume->updated_at}}</td>
				<td><a href="albumes/{{$albume->id}}/edit" id="athr_edit_{{$albume->id}}"><i class="fa fa-edit fa-lg" aria-hidden="true" title="Editar"></i></a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@else
	<h1>No hay registros</h1>
	@endif
</div><!-- ./box-body -->
@if($albumes->total() > 10)
<div class="box-footer text-center">
	{{$albumes->links()}}
</div>
@endif