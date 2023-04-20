<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantCreateAccountingEntryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_entry_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('accounting_entrie_id')->unsigned()->nullable();
            $table->unsignedInteger('account_movement_id');
            $table->integer('seat_line')->nullable();
            $table->float('debe', 12, 2)->default(0);
            $table->float('haber', 12, 2)->default(0);
            $table->string('seat_cost',50)->nullable();

            $table->foreign('accounting_entrie_id')->references('id')->on('accounting_entries')->onDelete('cascade');
            $table->foreign('account_movement_id')->references('id')->on('account_movements');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_entry_items');
    }
}
