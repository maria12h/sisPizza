@extends('layouts.inicio')
@section('contenido')
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-16">
		<h3>Listado de Trabajadores <a href="trabajador/create"><button class="btn btn-success">Nuevo</button></a> <a href="reportes/listaTrabajador"><button class="btn btn-Primary">Reporte</button></a></h3>
		@include('trabajador.search')
		<div class="col-lg-16 col-md-16 col-sm-16 col-xs-16">
			<div class="table-responsive">
				<table class="table table-striped tabel-bordered table-condensed table-hover">
					<thead>
						<th>ID</th>
						<th>Nombre</th>
						<th>Apellidos</th>
						<th>Telefono</th>
						<th>Dirección</th>
						<th>Correo Electronico</th>
						<th>Opcion</th>
					</thead>
					<tbody>
						@foreach($trabajador as $usu)
							<tr>
								<td>{{$usu->idtrabajador}}</td>
								<td>{{$usu->nombretrabajador}}</td>
								<td>{{$usu->apellidos}}</td>
								<td>{{$usu->telefono}}</td>
								<td>{{$usu->direccion}}</td>
								<td>{{$usu->correo}}</td>
								<td>
									<a href="{{URL::action('TrabajadorController@edit',$usu->idtrabajador)}}"><button class="btn btn-info">Editar</button></a>
									<a href="" data-target="#modal-delete-{{$usu->idtrabajador}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
								</td>
							</tr>
						@include('trabajador.modal')
						@endforeach
					</tbody>
				</table>
			</div>
			{{$trabajador->render()}}
		</div>
	</div>
@endsection
