@extends('layouts.inicio')
@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Trabajador: {{$trabajador->nombre}}</h3>
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
	{!!Form::Open(array('action'=>array('TrabajadorController@update',$trabajador,$trabajador->idtrabajador),'method'=>'PATCH','files'=>'true'))!!}
		{{Form::token()}}
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="codigo">Nombre</label>
					<input class="form-control" required value="{{$trabajador->nombretrabajador}}" type="text" name="nombre"></input>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="apellidos">Apellidos</label>
					<input class="form-control" required value="{{$trabajador->apellidos}}" type="text" name="apellidos"></input>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="telefono">Telefono</label>
					<input class="form-control" required value="{{$trabajador->telefono}}" type="text" name="telefono"></input>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="direccion">Dirección</label>
					<input class="form-control" required value="{{$trabajador->direccion}}" type="text" name="direccion"></input>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="correo">Correo Electronico</label>
					<input class="form-control" required value="{{$trabajador->correo}}" type="text" name="correo" ></input>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="contrasenia">Contraseña Nueva</label>
				<input type="password" class="form-control"name="contrasenia" placeholder="Contraseña nueva"/>
			</div>
		</div>
			
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Guardar</button>
					<button class="btn btn-danger" type="reset">Cancelar</button>
				</div>
			</div>	
		</div>
	{!!Form::close()!!}
@endsection