@extends('layouts.inicio')
@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Pedido</h3>
			@if(count($errors)>0)
				<div class="alert alert-danger">
					<ul>
						@foreach($errors->all() as $error)
							<li>{{$error}}</li>
						@endforeach
					</ul>
				</div>
			@endif
		</div>
	</div>
	{!!Form::Open(array('url'=>'pedido','method'=>'POST','autocomplete'=>'off'))!!}
	{{Form::token()}}
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<label for="nombre">Cliente</label>
				<select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
					@foreach($cliente as $pro)
						<option value="{{$pro->idcliente}}">{{$pro->nombre}} {{$pro->apellidos}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="form-group">
				<label for="tipoComprobante">Tipo Comprobante</label>
				<select class="form-control" value="{{old('tipoComprobante')}}" name="tipoComprobante">
					<option value="Boleta">Boleta</option>
					<option value="Factura">Factura</option>
				</select>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="form-group">
				<label for="serieComprobante">Serie Comprobante</label>
				<input class="form-control" value="{{old('serieComprobante')}}" type="text" name="serieComprobante" placeholder="Serie Comprobante ..."></input>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="form-group">
				<label for="nrocomprobante">Numero Comprobante</label>
				<input class="form-control" required value="{{old('nrocomprobante')}}" type="text" name="nrocomprobante" placeholder="Numero Comprobante ..."></input>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<label>Producto</label>
						<select name="pidproducto" class="form-control selectpicker" id="pidproducto" data-live-search="true">
							@foreach($producto as $pro)
								<option value="{{$pro->idproducto}}">{{$pro->nombre}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="form-group">
						<label for="cantidad">Cantidad</label>
						<input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="cantidad..">
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="form-group">
						<label for="precioVenta">Precio Venta</label>
						<input type="number" name="pprecioVenta" id="pprecioVenta" class="form-control" placeholder="precio Venta..">
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="form-group">
						<button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color: #A9D0F5">
							<th>Opciones</th>
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Precio Venta</th>
							<th>Subtotal</th>
						</thead>
						<tbody></tbody>
						<tfoot>
							<th>TOTAL</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th><h4 id="total">S/.0.00</h4></th>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="guardar">
			<div class="form-group">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>
	{!!form::close()!!}
	@push('scripts')
		<script>
			$(document).ready(function(){
				$("#bt_add").click(function() {
					/* Act on the event */
					agregar();
				});
			});
			var cont=0;
			total=0;
			subtotal=[];
			$("#guardar").hide();
			function agregar(){
				idproducto=$("#pidproducto").val();
				producto=$("#pidproducto option:selected").text();
				cantidad=$("#pcantidad").val();
				precioVenta=$("#pprecioVenta").val();
				if(idproducto!="" && cantidad!="" && precioVenta!=""){
					subtotal[cont]=(cantidad*precioVenta);
					total=total+subtotal[cont];
					var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idproducto[]" value="'+idproducto+'">'+producto+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precioVenta[]" value="'+precioVenta+'"></td><td>'+subtotal[cont]+'</td></tr>';
					cont++;
					limpiar();
					$("#total").html("S/. "+total);
					evaluar();
					$("#detalles").append(fila);
				}
				else
				{
					alert("Error al ingresar el detalle de ingreso, revise los datos del producto");
				}
			}
			function limpiar() {
				// body...
				$("#pcantidad").val("");
				$("#pprecioVenta").val("");
			}
			function evaluar()
			{
				if(total>0)
				{
					$("#guardar").show();
				}
				else
				{
					$("#guardar").hide();
				}
			}
			function eliminar(index){
				total=total-subtotal[index];
				$("#total").html("S/. "+ total);
				$("#fila"+index).remove();
				evaluar();
			}
		</script>
	@endpush
@endsection
