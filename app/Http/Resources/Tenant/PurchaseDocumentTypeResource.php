<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseDocumentTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Tenant\PurchaseDocumentTypes2 $this */
        return $this->getCollectionData();
        /** Pasado al modelo  */
        return [
            'idType' => $this->idType,
            'short' => $this->short,
            'DocumentTypeID' => $this->DocumentTypeID,
            'active' => (bool) $this->active,
            'description' => $this->description,
            'accountant' =>(bool) $this->accountant,
            'stock' => (bool) $this->stock,
            'sign' => (bool) $this->sign,
        ];
    }
}
