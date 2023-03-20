<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
            'numeroImportacion' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        return [
            'numeroImportacion.required' => 'El número de la importacion es obligatorio.',
        ];
    }
}
