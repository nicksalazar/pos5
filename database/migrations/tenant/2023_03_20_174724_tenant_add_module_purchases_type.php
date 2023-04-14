<?php

use App\Models\Tenant\ModuleLevel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAddModulePurchasesType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('tenant')->table('modules')->insert(['value'=>'imports','description'=>'Importaciones', 'order_menu'=>13]);
        DB::connection('tenant')->table('module_levels')->insert(['value'=>'folder','description'=>'Carpeta Importaciones', 'module_id'=>27]);
        DB::connection('tenant')->table('module_levels')->insert(['value'=>'purchases_types','description'=>'Tipos documentos de compras', 'module_id'=>2]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
