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
            $table->date('seat_date')->nullable();
            $table->unsignedInteger('types_accounting_entrie_id');
            $table->string('comment', 100)->nullable();
            $table->string('serie', 20)->nullable();
            $table->integer('number')->default(0);
            $table->float('total_debe', 12, 2)->default(0);
            $table->float('total_haber', 12, 2)->default(0);
            $table->integer('revised1')->default(0);
            $table->integer('user_revised1')->default(0);
            $table->integer('revised2')->default(0);
            $table->integer('user_revised2')->default(0);
            $table->string('currency_type_id')->default('USD')->nullable();
            $table->integer('doctype')->default(0);
            $table->integer('is_client')->default(0);
            $table->uuid('external_id');
            $table->unsignedInteger('establishment_id')->nullable();
            $table->json('establishment');
            $table->char('prefix', 3);
            $table->string('filename')->nullable();
            $table->unsignedInteger('person_id')->nullable();
            $table->json('person')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('types_accounting_entrie_id')->references('id')->on('types_accounting_entries');
            $table->foreign('establishment_id')->references('id')->on('establishments')->onDelete('set null');
            $table->foreign('person_id')->references('id')->on('persons')->onDelete('set null');
            $table->foreign('currency_type_id')->references('id')->on('cat_currency_types')->onDelete('set null');
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
