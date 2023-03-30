<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAddClaveAccesoToRetencionesJoin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retenciones_join', function (Blueprint $table) {
            $table->string('claveAcceso', 255)->nullable();
            $table->char('status_id', 2)->default('01');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('retenciones_join', function (Blueprint $table) {
            $table->dropColumn('claveAcceso');
            $table->dropColumn('status_id');
        });
    }
}
