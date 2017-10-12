@extends('layouts.inicio')
@section('contenido')
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-16">
		<h3>Listado de ventas <a href="venta/create"><button class="btn btn-success">Nuevo</button></a> <a href="/reportes/listaVenta"><button class="btn btn-primary">Reporte</button></a></h3>
		@include('ventas.venta.search')
		<div class="col-lg-16 col-md-16 col-sm-16 col-xs-16">
			<div class="table-responsive">
				<table class="table table-striped tabel-bordered table-condensed table-hover">
					<thead>
						<th>Atendido por</th>
						<th>Fecha</th>
						<th>Cliente</th>
						<th>Comprobante</th>
						<th>Total</th>
						<th>Opcion</th>
					</thead>
					<tbody>
						@foreach($venta as $vent)
							<tr>
								<td>{{$vent->nombretrabajador}}</td>
								<td>{{$vent->fechaventa}}</td>
								<td>{{$vent->nombre}}</td>
								<td>{{$vent->tipoComprobante.': '.$vent->serieComprobante.' - '.$vent->nrocomprobante}}</td>
								<td>{{$vent->total}}</td>
								<td>
									<!--<a href="{{URL::action('VentaController@show',$vent->idventa)}}"><button class="btn btn-primary">Detalles</button></a>-->
									<a href="{{URL::action('VentaController@actionPdfComprobante',$vent->idventa)}}"><button class="btn btn-primary">Comprobante</button></a>
									<a href="" data-target="#modal-delete-{{$vent->idventa}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
								</td>
							</tr>
						@include('ventas.venta.modal')
						@endforeach
					</tbody>
				</table>
			</div>
			{{$venta->render()}}
		</div>
	</div>
@endsection
