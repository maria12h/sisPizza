@extends('layouts.inicio')
@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Trabajador</h3>
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
	{!!Form::Open(array('url'=>'trabajador','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
	{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="codigo">Nombre</label>
				<input class="form-control" required value="{{old('nombre')}}" type="text" name="nombre" placeholder="Nombre trabajador"></input>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="apellidos">Apellidos</label>
				<input class="form-control" required value="{{old('apellidos')}}" type="text" name="apellidos" placeholder="Apellidos ..."></input>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="codigo">Telefono</label>
				<input class="form-control" required value="{{old('telefono')}}" type="text" name="telefono" placeholder="telefono"></input>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="direccion">Dirección</label>
				<input class="form-control" required value="{{old('direccion')}}" type="text" name="direccion" placeholder="Dirección ..."></input>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="correo">Correo Electronico</label>
				<input class="form-control" required value="{{old('correo')}}" type="email" name="correo" placeholder="Correo Electronico"></input>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="contrasenia">Contraseña</label>
				<input type="password" class="form-control" value="{{old('contrasenia')}}" name="contrasenia" placeholder="Contraseña"/>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>
	{!!form::close()!!}
@endsection
