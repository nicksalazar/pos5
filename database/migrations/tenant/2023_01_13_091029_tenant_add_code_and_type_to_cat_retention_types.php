<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAddCodeAndTypeToCatRetentionTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cat_retention_types', function (Blueprint $table) {
            $table->string('code');
            $table->char('type_id', 2)->nullable();

            $table->foreign('type_id')->references('id')->on('cat_add_retention_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cat_retention_types', function (Blueprint $table) {
            //
        });
    }
}
