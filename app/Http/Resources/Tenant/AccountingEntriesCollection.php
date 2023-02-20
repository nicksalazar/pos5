<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AccountingEntriesCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
            return [
                'id' => $row->id,
                'name' => $row->user_id,
                'user_id' => $row->user_id,
                'seat' => $row->seat,
                'seat_general' => $row->seat_general,
                'seat_line' => $row->seat_line,
                'seat_date' => $row->seat_date->format('Y-m-d'),
                'account_code' => $row->account_code,
                'types_accounting_entries_id' => $row->types_accounting_entries_id,
                'comment' => $row->comment,
                'serie' => $row->serie,
                'number' => $row->number,
                'debe' => $row->debe,
                'haber' => $row->haber,
                'seat_cost' => $row->seat_cost,
                'revised1' => $row->revised1,
                'user_revised1' => $row->user_revised1,
                'revised2' => $row->revised2,
                'user_revised2' => $row->user_revised2,
                'currency_code' => $row->currency_code,
                'doctype' => $row->doctype,
                'is_client' => $row->is_client,
                'third_code' => $row->third_code,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }
}