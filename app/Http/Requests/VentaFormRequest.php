<?php

namespace sisVentas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaFormRequest extends FormRequest
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
            'tipoComprobante'=>'required|max:20',
            'serieComprobante'=>'max:7',
            'numeroComprobante'=>'required|max:10',
            'cantidad'=>'required'
        ];
    }
}
