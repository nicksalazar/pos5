<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class DocumentTypePurchaseRequest extends FormRequest
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
            'idType' => [
                'required',
            ],
            'DocumentTypeID' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'tariff.required' => 'El número de la partida arancelaria es obligatorio.',
            'idType.required' => 'El identificador de documento es obligatorio.',
            'DocumentTypeID.required' => 'El tipo de documento asociado es obligatorio.',
        ];
    }
}
