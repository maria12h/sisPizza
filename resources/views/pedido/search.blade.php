{!! Form::open(array('url'=>'pedido','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
	<div class="form-group">
		<div class="input-group">
			<input class="form-control" type="text" name="searchText" placeholder="Buscar...." value="{{$searchText}}"></input>
			<span class="input-group-btn">
				<input class="btn btn-primary" type="submit" value="Buscar">
			</span>
		</div>
	</div>
{{Form::close()}}