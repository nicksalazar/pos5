<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenanAddTariffidToItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('concept_id')->unsigned()->nullable();
            $table->bigInteger('tariff_id')->unsigned()->nullable();

            $table->foreign('tariff_id')->references('id')->on('tariffs');
            $table->foreign('concept_id')->references('id')->on('import_concepts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            //
            $table->dropColumn('tariff_id');
        });
    }
}
