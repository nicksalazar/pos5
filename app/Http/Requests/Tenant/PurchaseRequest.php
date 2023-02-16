<?php

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'supplier_id' => [
				'required',
			],
			'number' => [
				'required',
				'numeric'
			],
			'series' => [
				'required',
			],
			'sequential_number' => [
				'required',
				'max:15'
			],
			'auth_number' => [
				'required',
				'min:10',
				'max:49'
			],
			'date_of_issue' => [
				'required',
			],
            'items' => [
                'required',
                'array',
            ],
            'ret' => [
                'required',
                'array',
            ],
		];
	}
}
