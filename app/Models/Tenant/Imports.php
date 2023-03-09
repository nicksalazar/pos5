<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Imports extends ModelTenant
{
    protected $table = 'import';
    protected $fillable = [
        'id',
        'numeroImportacion',
        'tipoTransporte',
        'fechaEmbarque',
        'fechaLlegada',
        'estado',
    ];
}
