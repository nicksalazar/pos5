<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAddImportToPurchaseItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            //
            $table->integer('import')->unsigned()->nullable();
            $table->integer('concepto')->unsigned()->nullable();

            $table->foreign('concepto')->references('id')->on('import_concepts');
            $table->foreign('import')->references('id')->on('import');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            //
            $table->dropColumn('import');
            $table->dropColumn('concepto');
        });
    }
}
