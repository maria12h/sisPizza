@extends('layouts.inicio')
@section('contenido')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="nombre">cliente</label>
				<p>{{$pedido->nombre}}</p>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="form-group">
				<label for="tipoComprobante">Tipo Comprobante</label>
				<p>{{$pedido->tipoComprobante}}</p>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="form-group">
				<label for="serieComprobante">Serie Comprobante</label>
				<p>{{$pedido->serieComprobante}}</p>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="form-group">
				<label for="numeroComprobante">Numero Comprobante</label>
				<p>{{$pedido->nrocomprobante}}</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color: #A9D0F5">
							<th>producto</th>
							<th>Cantidad</th>
							<th>Precio Venta</th>
							<th>Subtotal</th>
						</thead>
						<tbody>
							@foreach($detalles as $det)
							<tr>
								<td>{{$det->nombre}}</td>
								<td>{{$det->cantidad}}</td>
								<td>{{$det->precio}}</td>
								<td>{{$det->cantidad*$det->precio}}</td>
							</tr>
							@endforeach
						</tbody>
						<tfoot>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th><h4 id="total">S/.{{$pedido->total}}</h4></th>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection
