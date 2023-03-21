<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantCreateTipoDocPurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tipo_doc_purchase', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description', 255);
            $table->boolean('active')->nullable()->default(false);
            $table->timestamps();
        });

        DB::connection('tenant')->table('tipo_doc_purchase')->insert([

            ['description' => 'Documento importación','active'=> true],
            ['description' => 'Gasto importacion', 'active' => true],

        ]);


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_doc_purchase');
    }
}
