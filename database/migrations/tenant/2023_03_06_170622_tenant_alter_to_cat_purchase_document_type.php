<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantAlterToCatPurchaseDocumentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

       // DB::delete('delete cat_purchase_document_types where active = ?', ['1']);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::connection('tenant')->table('cat_purchase_document_types')->where('active', '1')->delete();

        DB::connection('tenant')->table('cat_purchase_document_types')->insert([
            ['id' => '01', 'active' => true,  'short' => 'CO', 'description' => 'Factura'],
            ['id' => '02', 'active' => true,  'short' => 'CO', 'description' => 'Nota o boleta de venta'],
            ['id' => '03', 'active' => true,  'short' => 'CO', 'description' => 'Liquidación de compra de Bienes o Prestación de servicios'],
            ['id' => '04', 'active' => true,  'short' => 'CO', 'description' => 'Nota de crédito'],
            ['id' => '05', 'active' => true,  'short' => 'CO', 'description' => 'Nota de débito'],
            ['id' => '06', 'active' => true,  'short' => 'CO', 'description' => 'Guías de Remisión'],
            ['id' => '07', 'active' => true,  'short' => 'CO', 'description' => 'Comprobante de Retención'],
            ['id' => '08', 'active' => true,  'short' => 'CO', 'description' => 'Boletos o entradas a espectáculos públicos'],
            ['id' => '09', 'active' => true,  'short' => 'CO', 'description' => 'Tiquetes o vales emitidos por máquinas registradoras'],
            ['id' => '11', 'active' => true,  'short' => 'CO', 'description' => 'Pasajes expedidos por empresas de aviación'],
            ['id' => '12', 'active' => true,  'short' => 'CO', 'description' => 'Documentos emitidos por instituciones financieras'],
            ['id' => '15', 'active' => true,  'short' => 'CO', 'description' => 'Comprobante de venta emitido en el Exterio'],
            ['id' => '16', 'active' => true,  'short' => 'CO', 'description' => 'Formulario Único de Exportación (FUE) o Declaración Aduanera Única (DAU) o Declaración Andina de Valor (DAV)'],
            ['id' => '18', 'active' => true,  'short' => 'CO', 'description' => 'Documentos autorizados utilizados en ventas excepto N/C N/D'],
            ['id' => '19', 'active' => true,  'short' => 'CO', 'description' => 'Comprobantes de Pago de Cuotas o Aportes'],
            ['id' => '20', 'active' => true,  'short' => 'CO', 'description' => 'Documentos por Servicios Administrativos emitidos por Inst. del Estado'],
            ['id' => '21', 'active' => true,  'short' => 'CO', 'description' => 'Carta de Porte Aéreo'],
            ['id' => '22', 'active' => true,  'short' => 'CO', 'description' => 'RECAP'],
            ['id' => '23', 'active' => true,  'short' => 'CO', 'description' => 'Nota de Crédito TC'],
            ['id' => '24', 'active' => true,  'short' => 'CO', 'description' => 'Nota de Débito TC'],
            ['id' => '41', 'active' => true,  'short' => 'CO', 'description' => 'Comprobante de venta emitido por reembolso'],
            ['id' => '42', 'active' => true,  'short' => 'CO', 'description' => 'Documento retención presuntiva y retención emitida por propio vendedor o por intermediario'],
            ['id' => '43', 'active' => true,  'short' => 'CO', 'description' => 'Liquidación para Explotación y Exploración de Hidrocarburos'],
            ['id' => '44', 'active' => true,  'short' => 'CO', 'description' => 'Comprobante de Contribuciones y Aportes'],
            ['id' => '45', 'active' => true,  'short' => 'CO', 'description' => 'Liquidación por reclamos de aseguradoras'],
            ['id' => '47', 'active' => true,  'short' => 'CO', 'description' => 'Nota de Crédito por Reembolso Emitida por Intermediario'],
            ['id' => '48', 'active' => true,  'short' => 'CO', 'description' => 'Nota de Débito por Reembolso Emitida por Intermediario'],
            ['id' => '49', 'active' => true,  'short' => 'CO', 'description' => 'Proveedor Directo de Exportador Bajo Régimen Especia'],
            ['id' => '50', 'active' => true,  'short' => 'CO', 'description' => 'A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta'],
            ['id' => '51', 'active' => true,  'short' => 'CO', 'description' => 'N/C A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta'],
            ['id' => '52', 'active' => true,  'short' => 'CO', 'description' => 'N/D A Inst. Estado y Empr. Públicas que percibe ingreso exento de Imp. Renta'],
            ['id' => '204', 'active' => true,  'short' => 'CO', 'description' => 'Liquidación de compra de Bienes Muebles Usados'],
            ['id' => '344', 'active' => true,  'short' => 'CO', 'description' => 'Liquidación de compra de vehículos usados'],
            ['id' => '364', 'active' => true,  'short' => 'CO', 'description' => 'Acta Entrega-Recepción PET'],
            ['id' => '370', 'active' => true,  'short' => 'CO', 'description' => 'Factura operadora transporte / socio'],
            ['id' => '371', 'active' => true,  'short' => 'CO', 'description' => 'Comprobante socio a operadora de transporte'],
            ['id' => '372', 'active' => true,  'short' => 'CO', 'description' => 'Nota de crédito operadora transporte / socio'],
            ['id' => '373', 'active' => true,  'short' => 'CO', 'description' => 'Nota de débito operadora transporte / socio'],
            ['id' => '374', 'active' => true,  'short' => 'CO', 'description' => 'Nota de débito operadora transporte / socio'],
            ['id' => '375', 'active' => true,  'short' => 'CO', 'description' => 'Liquidación de compra RISE de bienes o prestación de servicios'],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cat_purchase_document_type', function (Blueprint $table) {
            //
        });
    }
}
