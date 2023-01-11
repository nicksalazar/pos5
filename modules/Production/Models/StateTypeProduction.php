<?php

namespace Modules\Production\Models;

use App\Models\Tenant\ModelTenant;

class StateTypeProduction extends ModelTenant
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'state_types_production';

    
    public static function getDataApiApp()
    {
        $states = self::get();

        return $states->push([
            'id' => 'all',
            'description' => 'Todos',
        ]);
    }
}
