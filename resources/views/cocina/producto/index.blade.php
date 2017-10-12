@extends('layouts.inicio')
@section('contenido')
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-16">
		<h3>Listado de Pizza <a href="producto/create"><button class="btn btn-success">Nuevo</button></a> <a href="/reportes/listaProducto"><button class="btn btn-primary">Reporte</button></a></h3>
		@include('cocina.producto.search')
		<div class="col-lg-16 col-md-16 col-sm-16 col-xs-16">
			<div class="table-responsive">
				<table class="table table-striped tabel-bordered table-condensed table-hover">
					<thead>
						<th>ID</th>
						<th>Nombre</th>
						<th>Tipo pizza</th>
						<th>Descripcion</th>
						<th>Imagen</th>
						<th>Opcion</th>
					</thead>
					<tbody>
						@foreach($producto as $art)
							<tr>
								<td>{{$art->idproducto}}</td>
								<td>{{$art->nombre}}</td>
								<td>{{$art->tipoproducto}}</td>
								<td>{{$art->descripcion}}</td>
								<td>
									<img src="{{asset('imagenes/producto').'/'.$art->imagen}}" alt="{{$art->imagen}}" height="50px" width="50px" class="img-thumbnail">
								</td>
								<td>
									<a href="{{URL::action('ProductoController@edit',$art->idproducto)}}"><button class="btn btn-info">Editar</button></a>
									<a href="" data-target="#modal-delete-{{$art->idproducto}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
								</td>
							</tr>
						@include('cocina.producto.modal')
						@endforeach
					</tbody>
				</table>
			</div>
			{{$producto->render()}}
		</div>
	</div>
@endsection
