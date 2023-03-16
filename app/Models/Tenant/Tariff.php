<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class Tariff extends ModelTenant
{
    protected $table = 'tariffs';
    protected $fillable = [
        'id',
        'tariff',
        'advaloren',
        'specific_tariff',
        'fodinfa',
        'active',
        'eu_aviabilitie',
        'description',
    ];

    public function getCollectionData()
    {
        $data = [
            'id' => $this->id,
            'tariff' => $this->tariff,
            'advaloren' => $this->advaloren,
            'specific_tariff' => $this->specific_tariff,
            'fodinfa' => $this->fodinfa,
            'active' => $this->active,
            'eu_aviabilitie' => $this->eu_aviabilitie,
            'description' => $this->description,
        ];
        return $data;
    }
}
