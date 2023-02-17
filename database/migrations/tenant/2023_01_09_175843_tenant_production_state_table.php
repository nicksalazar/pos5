<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantProductionStateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('state_types_production', function (Blueprint $table) {
            $table->char('id', 2)->index();
            $table->string('description');
        });
        //JOINSOFTWARE ESTADOS DE DOCUMENTOS EN EL SRI//
        DB::table('state_types_production')->insert([
            ['id' => '01', 'description' => 'Registrado'],
            ['id' => '02', 'description' => 'En elaboracion'],
            ['id' => '03', 'description' => 'Finalizado'],
            ['id' => '04', 'description' => 'Anulado'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('state_types_production');
    }
}
