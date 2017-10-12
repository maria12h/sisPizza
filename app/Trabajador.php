<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table='trabajador';
    protected $primaryKey='idtrabajador';
    public $timestamps=false;//controlamos nosotros y si es true controla larabel
    protected $fillable =[
    	'nombretrabajador',
    	'apellidos',
    	'telefono',
        'direccion',
    	'correo',
    	'contrasenia'
    ];
    //se especifican cuando no queremos asignar al modelo
    protected $guarded =[
    ];
}
