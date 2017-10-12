@extends('layouts.inicio')
@section('contenido')
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-16">
		<h3>Listado de pedido <a href="pedido/create"><button class="btn btn-success">Nuevo</button></a> <a href="/reportes/listaPedido"><button class="btn btn-primary">Reporte</button></a></h3>
		@include('pedido.search')
		<div class="col-lg-16 col-md-16 col-sm-16 col-xs-16">
			<div class="table-responsive">
				<table class="table table-striped tabel-bordered table-condensed table-hover">
					<thead>
						<th>Cliente</th>
						<th>Fecha</th>
						<th>Tipo Comprobante</th>
						<th>Serie Comprobante</th>
						<th>Numero Comprobante</th>
						<th>Total</th>
						<th>Opcion</th>
					</thead>
					<tbody>
						@foreach($pedido as $pedi)
							<tr>
								<td>{{$pedi->nombre}}</td>
								<td>{{$pedi->fechapedido}}</td>
								<td>{{$pedi->tipoComprobante}}</td>
								<td>{{$pedi->serieComprobante}}</td>
								<td>{{$pedi->nrocomprobante}}</td>
								<td>{{$pedi->total}}</td>
								<td>
									<a href="{{URL::action('PedidoController@show',$pedi->idpedido)}}"><button class="btn btn-primary">Detalles</button></a>
									<a href="{{URL::action('PedidoController@actionPdfComprobante',$pedi->idpedido)}}"><button class="btn btn-primary">Comprobante</button></a>
									<a href="" data-target="#modal-delete-{{$pedi->idpedido}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
								</td>
							</tr>
						@include('pedido.modal')
						@endforeach
					</tbody>
				</table>
			</div>
			{{$pedido->render()}}
		</div>
	</div>
@endsection
