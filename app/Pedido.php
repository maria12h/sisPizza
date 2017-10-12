<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table='pedido';
    protected $primaryKey='idpedido';
    public $timestamps=false;//controlamos nosotros y si es true controla larabel
    protected $fillable =[
    	'tipoComprobante',
    	'serieComprobante',
    	'nroComprobante',
    	'fechapedido',
    	'idtrabajador',
    	'idcliente'
    ];
    //se especifican cuando no queremos asignar al modelo
    protected $guarded =[
    ];
}
