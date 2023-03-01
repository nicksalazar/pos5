<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAddCodAditionalFieldsToPersons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            //
            $table->string('parteRel', 2)->nullable()->default('NO');
            $table->string('pagoLocExt', 20)->nullable();
            $table->string('pagoLocExtDoc', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {

            Schema::dropIfExists('parteRel');
            Schema::dropIfExists('pagoLocExt');
            Schema::dropIfExists('pagoLocExtDoc');
        });
    }
}
