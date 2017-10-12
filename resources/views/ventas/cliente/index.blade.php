@extends('layouts.inicio')
@section('contenido')
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-16">
		<h3>Listado de clientes <a href="cliente/create"><button class="btn btn-success">Nuevo</button></a> <a href="/reportes/listaCliente"><button class="btn btn-primary">Reporte</button></a></h3>
		@include('ventas.cliente.search')
		<div class="col-lg-16 col-md-16 col-sm-16 col-xs-16">
			<div class="table-responsive">
				<table class="table table-striped tabel-bordered table-condensed table-hover">
					<thead>
						<th>ID</th>
						<th>Nombre</th>
						<th>Apellidos</th>
						<th>Telefono</th>
						<th>Dirección</th>
						<th>Opcion</th>
					</thead>
					<tbody>
						@foreach($cliente as $clien)
							<tr>
								<td>{{$clien->idcliente}}</td>
								<td>{{$clien->nombre}}</td>
								<td>{{$clien->apellidos}}</td>
								<td>{{$clien->telefono}}</td>
								<td>{{$clien->direccion}}</td>
								<td>
									<a href="{{URL::action('ClienteController@edit',$clien->idcliente)}}"><button class="btn btn-info">Editar</button></a>
									<a href="" data-target="#modal-delete-{{$clien->idcliente}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
								</td>
							</tr>
						@include('ventas.cliente.modal')
						@endforeach
					</tbody>
				</table>
			</div>
			{{$cliente->render()}}
		</div>
	</div>
@endsection
