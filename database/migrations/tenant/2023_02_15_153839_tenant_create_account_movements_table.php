<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantCreateAccountMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_movements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',50)->unique();
            $table->string('description',50);
            $table->boolean('cost_center');
            $table->string('type',50);
            $table->unsignedInteger('account_group_id');
            $table->timestamps();

            $table->foreign('account_group_id')->references('id')->on('account_groups');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_movements');
    }
}
