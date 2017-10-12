@extends('layouts.inicio')
@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar cliente: {{$cliente->nombre}}</h3>
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
	{!!Form::Open(array('action'=>array('ClienteController@update',$cliente,$cliente->idcliente),'method'=>'PATCH'))!!}
		{{Form::token()}}
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input class="form-control" required value="{{$cliente->nombre}}" type="text" name="nombre" placeholder="Nombre"></input>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="apellidos">Apellidos</label>
				<input class="form-control" required value="{{$cliente->apellidos}}" type="text" name="apellidos" placeholder="Apellidos"></input>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="telefono">Telefono</label>
				<input class="form-control" type="text" maxlength="15" value="{{$cliente->telefono}}" name="telefono" placeholder="Telefono"></input>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="direccion">Dirección</label>
				<input class="form-control" required value="{{$cliente->direccion}}" type="text" name="direccion" placeholder="Dirección"></input>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				{{csrf_field()}}
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
		</div>
	{!!Form::close()!!}
@endsection