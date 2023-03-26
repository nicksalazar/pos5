<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class DocumentTypesSustentoSRI extends ModelTenant
{
    protected $table = 'codigos_sustento';
    protected $fillable = [
        'id',
        'codSustento',
        'description',
        'idTipoComprobante',

    ];

    public function getCollectionData()
    {
        $data = [
            'id' => $this->id,
            'codSustento' => $this->codSustento,
            'description' => $this->description,
            'idTipoComprobante' => $this->idTipoComprobante,
        ];
        return $data;
    }
}
