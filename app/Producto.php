<?php

namespace sisVentas;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // 
    protected $table='producto';
    protected $primaryKey='idproducto';
    public $timestamps=false;//controlamos nosotros y si es true controla larabel
    protected $fillable =[
    	'nombre',
    	'descripcion',
        'tipoproducto',
    	'imagen'
    ];
    //se especifican cuando no queremos asignar al modelo
    protected $guarded =[
    ];
}
