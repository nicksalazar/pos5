<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class TariffRequest extends FormRequest
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
            'tariff' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'tariff.required' => 'El número de la partida arancelaria es obligatorio.',
        ];
    }
}
