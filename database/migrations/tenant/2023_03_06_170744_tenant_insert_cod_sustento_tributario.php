<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantInsertCodSustentoTributario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::connection('tenant')->table('codigos_sustento')->insert([

            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'01'],
            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'03'],
            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'04'],
            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'05'],
            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'11'],
            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'12'],
            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'21'],
            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'43'],
            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'47'],
            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'48'],
            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'204'],
            ['codSustento' => '01','description'=>'Crédito Tributario para declaración de IVA (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'344'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'01'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'02'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'03'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'04'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'05'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'09'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'11'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'12'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'21'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'41'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'43'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'47'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'48'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'204'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'344'],
            ['codSustento' => '02','description'=>'Costo o Gasto para declaración de IR (servicios y bienes distintos de inventarios y activos fijos)','idTipoComprobante'=>'364'],
            ['codSustento' => '03','description'=>'Activo Fijo - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'01'],
            ['codSustento' => '03','description'=>'Activo Fijo - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'03'],
            ['codSustento' => '03','description'=>'Activo Fijo - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'04'],
            ['codSustento' => '03','description'=>'Activo Fijo - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'05'],
            ['codSustento' => '03','description'=>'Activo Fijo - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'41'],
            ['codSustento' => '03','description'=>'Activo Fijo - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'47'],
            ['codSustento' => '03','description'=>'Activo Fijo - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'48'],
            ['codSustento' => '03','description'=>'Activo Fijo - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'204'],
            ['codSustento' => '03','description'=>'Activo Fijo - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'364'],
            ['codSustento' => '04','description'=>'Activo Fijo - Costo o Gasto para declaración de IR','idTipoComprobante'=>'01'],
            ['codSustento' => '04','description'=>'Activo Fijo - Costo o Gasto para declaración de IR','idTipoComprobante'=>'02'],
            ['codSustento' => '04','description'=>'Activo Fijo - Costo o Gasto para declaración de IR','idTipoComprobante'=>'03'],
            ['codSustento' => '04','description'=>'Activo Fijo - Costo o Gasto para declaración de IR','idTipoComprobante'=>'04'],
            ['codSustento' => '04','description'=>'Activo Fijo - Costo o Gasto para declaración de IR','idTipoComprobante'=>'05'],
            ['codSustento' => '04','description'=>'Activo Fijo - Costo o Gasto para declaración de IR','idTipoComprobante'=>'15'],
            ['codSustento' => '04','description'=>'Activo Fijo - Costo o Gasto para declaración de IR','idTipoComprobante'=>'41'],
            ['codSustento' => '04','description'=>'Activo Fijo - Costo o Gasto para declaración de IR','idTipoComprobante'=>'47'],
            ['codSustento' => '04','description'=>'Activo Fijo - Costo o Gasto para declaración de IR','idTipoComprobante'=>'48'],
            ['codSustento' => '04','description'=>'Activo Fijo - Costo o Gasto para declaración de IR','idTipoComprobante'=>'204'],
            ['codSustento' => '04','description'=>'Activo Fijo - Costo o Gasto para declaración de IR','idTipoComprobante'=>'344'],
            ['codSustento' => '05','description'=>'Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleado y no de la empresa)','idTipoComprobante'=>'01'],
            ['codSustento' => '05','description'=>'Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleado y no de la empresa)','idTipoComprobante'=>'02'],
            ['codSustento' => '05','description'=>'Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleado y no de la empresa)','idTipoComprobante'=>'03'],
            ['codSustento' => '05','description'=>'Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleado y no de la empresa)','idTipoComprobante'=>'04'],
            ['codSustento' => '05','description'=>'Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleado y no de la empresa)','idTipoComprobante'=>'05'],
            ['codSustento' => '05','description'=>'Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleado y no de la empresa)','idTipoComprobante'=>'11'],
            ['codSustento' => '05','description'=>'Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleado y no de la empresa)','idTipoComprobante'=>'15'],
            ['codSustento' => '05','description'=>'Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleado y no de la empresa)','idTipoComprobante'=>'41'],
            ['codSustento' => '05','description'=>'Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleado y no de la empresa)','idTipoComprobante'=>'204'],
            ['codSustento' => '05','description'=>'Liquidación Gastos de Viaje, hospedaje y alimentación Gastos IR (a nombre de empleado y no de la empresa)','idTipoComprobante'=>'344'],
            ['codSustento' => '06','description'=>'Inventario - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'01'],
            ['codSustento' => '06','description'=>'Inventario - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'03'],
            ['codSustento' => '06','description'=>'Inventario - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'04'],
            ['codSustento' => '06','description'=>'Inventario - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'05'],
            ['codSustento' => '06','description'=>'Inventario - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'41'],
            ['codSustento' => '06','description'=>'Inventario - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'43'],
            ['codSustento' => '06','description'=>'Inventario - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'47'],
            ['codSustento' => '06','description'=>'Inventario - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'48'],
            ['codSustento' => '06','description'=>'Inventario - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'204'],
            ['codSustento' => '06','description'=>'Inventario - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'344'],
            ['codSustento' => '06','description'=>'Inventario - Crédito Tributario para declaración de IVA','idTipoComprobante'=>'344'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'01'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'02'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'03'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'04'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'05'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'15'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'41'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'43'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'47'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'204'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'344'],
            ['codSustento' => '07','description'=>'Inventario - Costo o Gasto para declaración de IR','idTipoComprobante'=>'364'],
            ['codSustento' => '08','description'=>'Valor pagado para solicitar Reembolso de Gasto (intermediario)','idTipoComprobante'=>'01'],
            ['codSustento' => '08','description'=>'Valor pagado para solicitar Reembolso de Gasto (intermediario)','idTipoComprobante'=>'02'],
            ['codSustento' => '08','description'=>'Valor pagado para solicitar Reembolso de Gasto (intermediario)','idTipoComprobante'=>'03'],
            ['codSustento' => '08','description'=>'Valor pagado para solicitar Reembolso de Gasto (intermediario)','idTipoComprobante'=>'04'],
            ['codSustento' => '08','description'=>'Valor pagado para solicitar Reembolso de Gasto (intermediario)','idTipoComprobante'=>'05'],
            ['codSustento' => '08','description'=>'Valor pagado para solicitar Reembolso de Gasto (intermediario)','idTipoComprobante'=>'21'],
            ['codSustento' => '08','description'=>'Valor pagado para solicitar Reembolso de Gasto (intermediario)','idTipoComprobante'=>'204'],
            ['codSustento' => '08','description'=>'Valor pagado para solicitar Reembolso de Gasto (intermediario)','idTipoComprobante'=>'344'],
            ['codSustento' => '08','description'=>'Valor pagado para solicitar Reembolso de Gasto (intermediario)','idTipoComprobante'=>'344'],
            ['codSustento' => '09','description'=>'Reembolso por Siniestros','idTipoComprobante'=>'01'],
            ['codSustento' => '09','description'=>'Reembolso por Siniestros','idTipoComprobante'=>'04'],
            ['codSustento' => '09','description'=>'Reembolso por Siniestros','idTipoComprobante'=>'05'],
            ['codSustento' => '09','description'=>'Reembolso por Siniestros','idTipoComprobante'=>'45'],
            ['codSustento' => '10','description'=>'Distribución de Dividendos, Beneficios o Utilidades','idTipoComprobante'=>'19'],
            ['codSustento' => '11','description'=>'Convenios de débito o recaudación para IFI´s','idTipoComprobante'=>'12'],
            ['codSustento' => '12','description'=>'Impuestos y retenciones presuntivos','idTipoComprobante'=>'42'],
            ['codSustento' => '13','description'=>'Valores reconocidos por entidades del sector público a favor de sujetos pasivos','idTipoComprobante'=>'19'],
            ['codSustento' => '14','description'=>'Valores facturados por socios a operadoras de transporte (que no constituyen gasto de dicha operadora)','idTipoComprobante'=>'01'],
            ['codSustento' => '14','description'=>'Valores facturados por socios a operadoras de transporte (que no constituyen gasto de dicha operadora)','idTipoComprobante'=>'02'],
            ['codSustento' => '14','description'=>'Valores facturados por socios a operadoras de transporte (que no constituyen gasto de dicha operadora)','idTipoComprobante'=>'03'],
            ['codSustento' => '14','description'=>'Valores facturados por socios a operadoras de transporte (que no constituyen gasto de dicha operadora)','idTipoComprobante'=>'04'],
            ['codSustento' => '14','description'=>'Valores facturados por socios a operadoras de transporte (que no constituyen gasto de dicha operadora)','idTipoComprobante'=>'05'],
            ['codSustento' => '15','description'=>'Pagos efectuados por consumos propios y de terceros de servicios digitales','idTipoComprobante'=>'01'],
            ['codSustento' => '15','description'=>'Pagos efectuados por consumos propios y de terceros de servicios digitales','idTipoComprobante'=>'02'],
            ['codSustento' => '15','description'=>'Pagos efectuados por consumos propios y de terceros de servicios digitales','idTipoComprobante'=>'03'],
            ['codSustento' => '15','description'=>'Pagos efectuados por consumos propios y de terceros de servicios digitales','idTipoComprobante'=>'04'],
            ['codSustento' => '15','description'=>'Pagos efectuados por consumos propios y de terceros de servicios digitales','idTipoComprobante'=>'05'],
            ['codSustento' => '15','description'=>'Pagos efectuados por consumos propios y de terceros de servicios digitales','idTipoComprobante'=>'12'],
            ['codSustento' => '15','description'=>'Pagos efectuados por consumos propios y de terceros de servicios digitales','idTipoComprobante'=>'15'],
            ['codSustento' => '00','description'=>'Casos especiales cuyo sustento no aplica en las opciones anteriores','idTipoComprobante'=>'01'],
            ['codSustento' => '00','description'=>'Casos especiales cuyo sustento no aplica en las opciones anteriores','idTipoComprobante'=>'02'],
            ['codSustento' => '00','description'=>'Casos especiales cuyo sustento no aplica en las opciones anteriores','idTipoComprobante'=>'04'],
            ['codSustento' => '00','description'=>'Casos especiales cuyo sustento no aplica en las opciones anteriores','idTipoComprobante'=>'05'],
            ['codSustento' => '00','description'=>'Casos especiales cuyo sustento no aplica en las opciones anteriores','idTipoComprobante'=>'19'],
            ['codSustento' => '00','description'=>'Casos especiales cuyo sustento no aplica en las opciones anteriores','idTipoComprobante'=>'42'],

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
        DB::connection('tenant')->table('codigos_sustento')->delete();
    }
}
