<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountGroupRequest extends FormRequest
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
                Rule::unique('tenant.account_groups')->ignore($id),
            ],
            'description' => [
                'required',
            ],
            'type' => [
                'required',
            ]
        ];
    }
}