<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class AccountEntriesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        return [
            'items.*.account_movement_id' => [
                'required',
            ],
            'types_accounting_entrie_id' => [
                'required',
            ],
            /*'person_id' => [
                'required',
            ],*/
            'items.*.seat_cost' => [
               'required_if:items.*.typecost,1',
            ],
        ];
    }
    public function messages()
    {
        return [
            'items.*.account_movement_id.required' => 'El campo Cuenta es obligatorio.',
            'types_accounting_entrie_id.required' => 'El Tipo asiento es obligatorio.',
            'person_id.required' => 'El campo es requerido.',
            'items.*.seat_cost.required_if' => 'Centro costo es obligatorio',
        ];
    }

}
