<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class PurchaseDocumentTypes2 extends ModelTenant
{
    protected $table = 'cat_purchase_document_types2';
    protected $fillable = [
        'idType',
        'active',
        'short',
        'description',
        'DocumentTypeID',
        'accountant',
        'stock',
        'sign',
    ];

    public function getCollectionData()
    {
        $data = [
            'idType' => $this->idType,
            'short' => $this->short,
            'DocumentTypeID' => $this->DocumentTypeID,
            'active' => $this->active,
            'description' => $this->description,
            'accountant' => $this->accountant,
            'stock' => $this->stock,
            'sign' => $this->sign,
        ];
        return $data;
    }
}
