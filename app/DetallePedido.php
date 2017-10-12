<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    //
    protected $table='detallepedido';
    protected $primaryKey='iddetallepedido';
    public $timestamps=false;//controlamos nosotros y si es true controla larabel
    protected $fillable =[
    	'cantidad',
    	'precio',
        'idproducto',
        'idpedido'
    ];
    //se especifican cuando no queremos asignar al modelo
    protected $guarded =[
    ];
}
