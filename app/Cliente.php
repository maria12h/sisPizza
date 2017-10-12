<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table='cliente';
    protected $primaryKey='idcliente';
    public $timestamps=false;//controlamos nosotros y si es true controla larabel
    protected $fillable =[
    	'nombre',
    	'apellidos',
    	'telefono',
    	'direccion'
    ];
    //se especifican cuando no queremos asignar al modelo
    protected $guarded =[
    ];
}
