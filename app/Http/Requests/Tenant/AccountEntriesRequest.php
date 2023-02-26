<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;

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
            'items.*.types_accounting_entrie_id' => [
                'required',
            ],
            'items.*.seat_cost' => [
               ' required_if:items.*.typecost,1',
            ],
        ];
    }
    public function messages()
    {
        return [
            'items.*.account_movement_id.required' => 'El campo Cuenta es obligatorio.',
            'items.*.types_accounting_entrie_id.required' => 'El Tipo asiento es obligatorio.',
            'items.*.seat_cost.required_if' => 'Centro costo es obligatorio',
        ];
    }

    /* public function validated()
    {
        if ($this->invalid()) {
            throw new ValidationException($this);
        }

        $results = [];

        $missingValue = Str::random(10);

        foreach ($this->getRules() as $key => $rules) {
            if(in_array('array', $rules)){
               continue; // skip array rules, expect to be sub rules.
            }
            $value = data_get($this->getData(), $key, $missingValue);

            if ($value !== $missingValue) {
                Arr::set($results, $key, $value);
            }
        }

        return $results;
    }*/
}
