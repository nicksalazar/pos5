<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantPurchaseCatPurchaseDocumentTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_purchase_document_types', function (Blueprint $table) {
            $table->string('id')->index();
            $table->boolean('active');
            $table->string('short')->nullable();
            $table->string('description');
        });

        DB::table('cat_purchase_document_types')->insert([
            ['id' => '01', 'active' => true,  'short' => 'CO', 'description' => 'FACTURA'],
            ['id' => '02', 'active' => true,  'short' => 'CO', 'description' => 'NOTA O BOLETA DE VENTA'],
            ['id' => '03', 'active' => true,  'short' => 'CO', 'description' => 'Liquidación de compra de Bienes o Prestación de servicios'],
            ['id' => '04', 'active' => true,  'short' => 'CO', 'description' => 'NOTA DE CRÉDITO'],
            ['id' => '05', 'active' => true,  'short' => 'CO', 'description' => 'NOTA DE DÉBITO'],
            ['id' => '06', 'active' => true,  'short' => 'CO', 'description' => 'GUÍAS DE REMISIÓN'],
            ['id' => '07', 'active' => true,  'short' => 'CO', 'description' => 'COMPROBANTE DE RETENCIÓN'],
            ['id' => '08', 'active' => true,  'short' => 'CO', 'description' => 'Boletos o entradas a espectáculos públicos'],
            ['id' => '09', 'active' => true, 'short' => 'CO', 'description' => 'Tiquetes o vales emitidos por máquinas registradoras'],
            ['id' => '11', 'active' => true, 'short' => 'CO', 'description' => 'Pasajes expedidos por empresas de aviación'],
            ['id' => '12', 'active' => true, 'short' => 'CO', 'description' => 'Documentos emitidos por instituciones financieras'],
            ['id' => '15', 'active' => true, 'short' => 'CO', 'description' => 'Comprobante de venta emitido en el Exterior'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_purchase_document_types');
    }
}
