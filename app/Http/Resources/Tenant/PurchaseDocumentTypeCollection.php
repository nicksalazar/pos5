<?php

namespace App\Http\Resources\Tenant;

use App\Models\Tenant\EmailSendLog;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PurchaseDocumentTypeCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function toArray($request) {
        return $this->collection->transform(function(\App\Models\Tenant\PurchaseDocumentTypes2 $row, $key) {

            return [
                'idType' => $row->idType,
                'short' => $row->short,
                'DocumentTypeID' => $row->DocumentTypeID,
                'active' => (bool) $row->active,
                'description' => $row->description,
                'accountant' =>(bool) $row->accountant,
                'stock' => (bool) $row->stock,
                'sign' => (bool) $row->sign,

            ];
        });
    }

}
