@extends('layouts.inicio')
@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Pizza: {{$producto->nombre}}</h3>
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
	{!!Form::Open(array('action'=>array('ProductoController@update',$producto,$producto->idproducto),'method'=>'PATCH','files'=>'true'))!!}
		{{Form::token()}}
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="nombre">Nombre</label>
					<input class="form-control" required value="{{$producto->nombre}}" type="text" name="nombre"></input>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="idCategoria">Tipo pizza</label>
					<select class="form-control" name="tipoproducto">
						@if($producto->tipoproducto == "Personal")
							<option value="Personal" selected>Personal</option>
							<option value="Mediano">Mediano</option>
							<option value="Familiar">Familiar</option>
						
						@elseif($producto->tipoproducto == "Mediano")
							<option value="Personal">Personal</option>
							<option value="Mediano" selected>Mediano</option>
							<option value="Familiar">Familiar</option>
						
						@else
							<option value="Personal">Personal</option>
							<option value="Mediano">Mediano</option>
							<option value="Familiar" selected>Familiar</option>
						@endif
					</select>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="descripcion">Descripcion</label>
					<textarea class="form-control" name="descripcion" >{{$producto->descripcion}}</textarea>
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="form-group">
					<label for="imagen">Imagen</label>
					<input class="form-control"  type="file" name="imagen"></input>
					@if(($producto->imagen)!="")
						<img src="{{asset('imagenes/producto').'/'.$producto->imagen}}" width="300px" height="300px">
					@endif
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