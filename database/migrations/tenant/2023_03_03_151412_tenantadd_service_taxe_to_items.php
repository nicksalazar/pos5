<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantaddServiceTaxeToItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            //
            $table->boolean('has_service_taxes')->nullable()->default(false);
            $table->decimal('amount_service_taxes', 6, 2)->nullable();
        });

        Schema::table('configurations', function (Blueprint $table) {

            $table->decimal('amount_service_taxes', 6, 2)->nullable();
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
            Schema::dropIfExists('has_service_taxes');
            Schema::dropIfExists('amount_service_taxes');
        });

        Schema::table('configurations', function (Blueprint $table) {

           Schema::dropIfExists('amount_service_taxes');
        });
    }
}
