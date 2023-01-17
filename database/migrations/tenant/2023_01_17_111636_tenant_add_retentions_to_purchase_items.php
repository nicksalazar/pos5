<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAddRetentionsToPurchaseItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->string('retention_type_id_income')->nullable();
            $table->string('retention_type_id_iva')->nullable();
            $table->decimal('income_retention', 10, 4)->nullable();
            $table->decimal('iva_retention', 10, 4)->nullable();

	        $table->foreign('retention_type_id_income')->references('id')->on('cat_retention_types');
            $table->foreign('retention_type_id_iva')->references('id')->on('cat_retention_types');
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
        });
    }
}
