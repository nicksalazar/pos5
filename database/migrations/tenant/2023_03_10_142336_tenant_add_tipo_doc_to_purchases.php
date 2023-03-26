<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAddTipoDocToPurchases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {

            $table->integer('tipo_doc_id')->unsigned()->nullable();
            $table->integer('import_id')->unsigned()->nullable();

            $table->foreign('tipo_doc_id')->references('id')->on('tipo_doc_purchase');
            $table->foreign('import_id')->references('id')->on('import');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('tipo_doc_id');
        });
    }
}
