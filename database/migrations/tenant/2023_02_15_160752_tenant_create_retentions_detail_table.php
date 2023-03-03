<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantCreateRetentionsDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('retentions_detail_ec', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idRetencion',50);
            $table->string('codRetencion',10);
            $table->double('baseRet',12,2);
            $table->double('porcentajeRet',12,2);
            $table->double('valorRet',12,2);
            $table->foreign('idRetencion')->references('idRetencion')->on('retenciones_join')->onDelete('cascade');

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
    }
}
