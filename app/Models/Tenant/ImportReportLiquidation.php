<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Model;

class ImportReportLiquidation extends ModelTenant
{
    protected $fillable = [
        'serie',
        'numero',
        'importacion',
        'numLinea',
        'codArticulo',
        'referencia',
        'descripcion',
        'partidaArancelaria',
        'porcentajeAdvaloren',
        'unidadestotal',
        'fob',
        'fobTotal',
        'flete',
        'fleteTotal',
        'seguro',
        'seguroTotal',
        'cif',
        'advaloren',
        'fodinfa',
        'iva',
        'gastos',
        'gastosTotal',
        'costo',
        'totalLinea',
        'factor',
    ];
}
