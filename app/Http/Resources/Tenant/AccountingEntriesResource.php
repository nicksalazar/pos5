<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountingEntriesResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
            return [
                'id' => $this->id,
                'name' => $this->user_id,
                'user_id' => $this->user_id,
                'seat' => $this->seat,
                'seat_general' => $this->seat_general,
                'seat_line' => $this->seat_line,
                'seat_date' => $this->seat_date->format('Y-m-d'),
                'account_code' => $this->account_code,
                'types_accounting_entrie_id' => $this->types_accounting_entrie_id,
                'comment' => $this->comment,
                'serie' => $this->serie,
                'number' => $this->number,
                'debe' => $this->debe,
                'haber' => $this->haber,
                'seat_cost' => $this->seat_cost,
                'revised1' => $this->revised1,
                'user_revised1' => $this->user_revised1,
                'revised2' => $this->revised2,
                'user_revised2' => $this->user_revised2,
                'currency_code' => $this->currency_code,
                'doctype' => $this->doctype,
                'is_client' => $this->is_client,
                'person_id' => $this->person_id,
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            ];

        
    }
}