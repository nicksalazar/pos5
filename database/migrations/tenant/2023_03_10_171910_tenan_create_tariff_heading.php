<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenanCreateTariffHeading extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tariff', 255);
            $table->double('advaloren', 15, 3)->default(0);
            $table->double('specific_tariff', 15, 3)->default(0);
            $table->double('fodinfa', 15, 3)->default(0);
            $table->boolean('active')->default(true);
            $table->boolean('eu_aviabilitie')->default(false);
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tariffs');
    }
}
