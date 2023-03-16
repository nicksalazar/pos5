<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountMovementsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->input('id');
        return [
            'code' => [
                'required',
                Rule::unique('tenant.account_movements')->ignore($id),
                'max:50',
            ],
            'description' => [
                'required',
                'max:50',
            ],
            'cost_center' => [
                'required',
            ],
            'account_group_id' => [
                'required',
            ]
        ];
    }
}