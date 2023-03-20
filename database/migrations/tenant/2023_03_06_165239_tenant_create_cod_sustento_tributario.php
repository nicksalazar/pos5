<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantCreateCodSustentoTributario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('codigos_sustento', function (Blueprint $table) {

            $table->increments('id');
            $table->string('codSustento',2);
            $table->string('description', 255);
            $table->string('idTipoComprobante',255);
            $table->foreign('idTipoComprobante')->references('id')->on('cat_purchase_document_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('codigos_sustento');
    }
}
