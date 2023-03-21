<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantCreateImport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('import', function (Blueprint $table) {

            $table->increments('id');
            $table->string('numeroImportacion',255)->unique();
            $table->string('tipoTransporte', 255)->nullable();
            $table->date('fechaEmbarque')->nullable();
            $table->date('fechaLlegada')->nullable();
            $table->string('estado', 255)->nullable()->default('Registrada');
            $table->timestamps();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('import');
    }
}
