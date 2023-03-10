<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantCreatConceptosImportItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('import_concepts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 255);
            $table->timestamps();
        });

        DB::connection('tenant')->table('import_concepts')->insert([

            ['description' => 'Gastos locales'],
            ['description' => 'Aranceles'],
            ['description' => 'Isd'],
            ['description' => 'Flete'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_concepts');
    }
}
