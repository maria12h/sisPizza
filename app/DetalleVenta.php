<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table='detalleventa';
    protected $primaryKey='iddetalleventa';
    public $timestamps=false;//controlamos nosotros y si es true controla larabel
    protected $fillable =[
    	'cantidad',
    	'precio',
    	'idventa',
        'idproducto'
    ];
    //se especifican cuando no queremos asignar al modelo
    protected $guarded =[
    ];
}
