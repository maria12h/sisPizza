<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='venta';
    protected $primaryKey='idventa';
    public $timestamps=false;//controlamos nosotros y si es true controla larabel
    protected $fillable =[
        'tipocomprobante',
        'seriecomprobante',
    	'nrocomprobante',
    	'fechaventa',
    	'total',
    	'idcliente',
    	'idtrabajador'
    ];
    //se especifican cuando no queremos asignar al modelo
    protected $guarded =[
    ];
}
