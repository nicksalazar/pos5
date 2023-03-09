<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAddRowInventoryTransaction103And104 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('inventory_transactions')->insert([
            ['id' => 103, 'name' => 'Salida por insumo anulado', 'type' => 'output'],
            ['id' => 104, 'name' => 'Entrada por insumo anulado', 'type' => 'input']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('inventory_transactions')->whereIn('id', [103, 104])->delete();
    }
}