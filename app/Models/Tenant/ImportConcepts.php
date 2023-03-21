<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class ImportConcepts extends ModelTenant
{
    protected $table = 'import_concepts';
    protected $fillable = [
        'id',
        'description',
    ];
}
