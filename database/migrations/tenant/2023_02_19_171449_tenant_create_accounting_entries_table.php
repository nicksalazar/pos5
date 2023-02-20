<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantCreateAccountingEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->integer('seat');
            $table->integer('seat_general');
            $table->integer('seat_line')->nullable();
            $table->date('seat_date')->nullable();
            $table->string('account_code',20)->nullable();
            $table->unsignedInteger('types_accounting_entries_id');
            $table->string('comment',100)->nullable();
            $table->string('serie',20)->nullable();
            $table->integer('number')->default(0);
            $table->float('debe', 12, 2)->default(0);
            $table->float('haber', 12, 2)->default(0);
            $table->string('seat_cost',50)->nullable();
            $table->integer('revised1')->default(0);
            $table->integer('user_revised1')->default(0);
            $table->integer('revised2')->default(0);
            $table->integer('user_revised2')->default(0);
            $table->integer('currency_code')->default(0);
            $table->integer('doctype')->default(0);
            $table->integer('is_client')->default(0);
            $table->string('third_code',100)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('types_accounting_entries_id')->references('id')->on('types_accounting_entries');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounting_entries');
    }
}
