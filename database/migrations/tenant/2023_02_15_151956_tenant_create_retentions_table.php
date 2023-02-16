<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantCreateRetentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retenciones_join', function (Blueprint $table) {

            $table->increments('id');
            $table->string('idRetencion',50)->unique();
            $table->integer('idDocumento')->unsigned();
            $table->integer('idProveedor')->unsigned();
            $table->string('fechaFizcal',50);
            $table->string('establecimiento',3);
            $table->string('ptoEmision',3);
            $table->string('secuencial',9)->unique();
            $table->string('codSustento',2);
            $table->string('codDocSustento',5);
            $table->string('numAuthSustento',49);
            $table->timestamps();
            $table->foreign('idProveedor')->references('id')->on('persons');
            $table->foreign('idDocumento')->references('id')->on('purchases');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retentions_ec');
    }
}
