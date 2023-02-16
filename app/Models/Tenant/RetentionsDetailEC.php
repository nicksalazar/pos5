<?php

namespace App\Models\Tenant;

use App\Models\Tenant\ModelTenant;
use Illuminate\Database\Eloquent\Model;

class RetentionsDetailEC extends ModelTenant
{
    protected $table = 'retentions_detail_ec';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'idRetencion',
        'codRetencion',
        'baseRet',
        'porcentajeRet',
        'valorRet',
    ];
}
