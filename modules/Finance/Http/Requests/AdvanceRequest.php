<?php

namespace Modules\Finance\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdvanceRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'idMethodType' => [
                'required',
            ],
            'idCliente' => [
                'required',
            ],
            'valor' => [
                'required',
            ],
        ];
    }
    public function messages()
	{
		return [
			'idMethodType.required' => 'El tipo de Anticipo es obligatorio',
            'idCliente.required' => 'DEbe seleccionar un cliente/Proveedor',
            'valor.required' => 'El valor del anticipo no puede ser 0 (cero) o null',
		];
	}
}
