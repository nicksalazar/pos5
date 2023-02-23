<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Grammars\ChangeColumn;

class TenantAlter2SecuencialToRetencionesJoin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('retenciones_join', function (Blueprint $table) {

            Schema::dropIfExists('secuencial');           

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
            //
            Schema::dropIfExists('secuencial');
        });
    }
}
