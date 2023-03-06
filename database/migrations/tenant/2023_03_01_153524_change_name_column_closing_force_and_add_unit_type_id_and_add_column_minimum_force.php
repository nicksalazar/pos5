<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameColumnClosingForceAndAddUnitTypeIdAndAddColumnMinimumForce extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::table('machines', function (Blueprint $table) {
            // 1. Renaming column
            $table->renameColumn('closing_force', 'maximum_force');

            // 2. Adding new column
            $table->string('minimum_force')->nullable()->after('maximum_force');

            // 3. Adding foreign key column
            $table->string('unit_type_id', 255)->nullable()->after('name');
            $table->foreign('unit_type_id')->references('id')->on('cat_unit_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('machines', function (Blueprint $table) {
            $table->dropForeign('machines_unit_type_id_foreign');
            $table->dropColumn(['unit_type_id', 'minimum_force', 'maximum_force']);
            $table->renameColumn('maximum_force', 'closing_force');
        });
    }
}
