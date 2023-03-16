<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class TariffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Tenant\Person $this */
        return $this->getCollectionData();
        /** Pasado al modelo  */
        return [
            'id' => $this->id,
            'tariff' => $this->tariff,
            'advaloren' => $this->advaloren,
            'specific_tariff' => $this->specific_tariff,
            'fodinfa' => $this->fodinfa,
            'active' => (bool) $this->active,
            'eu_aviabilitie' => (bool) $this->eu_aviabilitie,
            'description' => $this->description,
        ];
    }
}
