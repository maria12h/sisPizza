<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{$vent->idventa}}">
	{!!Form::Open(array('action'=>array('VentaController@destroy',$vent->idventa),'method'=>'delete'))!!}
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button class="close" type="button" data-dismiss="modal" aria-label="close">
						<span aria-hidden="true">X</span>
					</button>
					<h4 class="modal-title">anular venta</h4>
				</div>
				<div class="modal-body">
					<p>Confirme si desea cancelar la venta</p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal" type="button">Cerrar</button>
					<button class="btn btn-primary" type="submit">Confirmar</button>
				</div>
			</div>
		</div>
	{!!Form::close()!!}
</div>