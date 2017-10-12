<?php

namespace sisVentas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrabajadorFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'nombre'=>'required|max:100',
            'apellidos'=>'required|max:100',
            'telefono'=>'required|max:9',
            'direccion'=>'required|max:45',
            'correo'=>'required|email',
            'contrasenia'=>'required'
        ];
    }
}