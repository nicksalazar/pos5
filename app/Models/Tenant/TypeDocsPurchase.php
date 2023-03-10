<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class TypeDocsPurchase extends ModelTenant
{
    protected $table = 'tipo_doc_purchase';
    protected $fillable = [
        'id',
        'description',
        'active',
    ];
}
