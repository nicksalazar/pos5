<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\EmailSendLog;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TariffCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request) {
        return $this->collection->transform(function(\App\Models\Tenant\Tariff $row, $key) {

            return [
                'id' => $row->id,
                'tariff' => $row->tariff,
                'advaloren' => $row->advaloren,
                'specific_tariff' => $row->specific_tariff,
                'fodinfa' => $row->fodinfa,
                'active' => (bool) $row->active,
                'eu_aviabilitie' => (bool) $row->eu_aviabilitie,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),

            ];
        });
    }

}
