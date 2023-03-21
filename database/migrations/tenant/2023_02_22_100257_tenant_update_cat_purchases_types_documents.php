<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantUpdateCatPurchasesTypesDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('cat_retention_types')->where('id', '01')->update(['code' => '303','type_id' => '01','description'=>'Retencion 10% Honorario Profesional','percentage'=>10]);
        DB::table('cat_retention_types')->where('id', '02')->update(['code' => '304','type_id' => '01','description'=>'Servicios predomina el intelecto no relacion','percentage'=>8]);
        //DB::delete('delete cat_retention_types' );
        //DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['0', 1, 10, 'Retencion 10% Honorario Profesional', '303','01']);
        //DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['02', 1, 8, 'Servicios predomina el intelecto no relacion', '304','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['03', 1, 2, '2% Servicios predomina la mano de obra', '307','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['04', 1, 1.75, 'Retencion 1.75 % Publicidad y Comunicación', '309','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['05', 1, 1, 'Retencion 1% Transporte Privado y Pasajeros', '310','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['06', 1, 2, 'Por pagos a través de liquidación de compra 2%', '311','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['07', 1, 1.75, 'Retencion 1.75 % Transferencia de Bienes Mueble', '312','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['08', 1, 8, 'Retencion 8% Arrendamiento Bienes Inmuebles', '320','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['09', 1, 1.75, 'Retencion 0.10% Seguros y Reaseguros', '322','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['10', 1, 2, 'Retencion 2% Intereses Financieros', '323','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['11', 1, 0, 'Pagos y Bienes No sujetos a Retencion', '332','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['12', 1, 1, 'Retencion Aplicables 1%', '343','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['13', 1, 8, 'Retencion Aplicables 8%', '345','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['14', 1, 10, '10%  Servicios tecnicos administrativos', '410','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['15', 1, 10, '10% Otros Conceptos de Ingresos Gravados', '411','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['16', 1, 25, '25% Servicios técnicos, administración o de compra', '421','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['17', 1, 25, '25% Otros Conceptos de Ingresos Gravados', '422','01']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['18', 1, 10, 'Retencion en IVA 10%', '721','02']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['19', 1, 20, 'Retencion en IVA 20%', '723','02']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['20', 1, 30, 'Retencion en IVA 30%', '725','02']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['21', 1, 70, 'Retención del 70%', '729','02']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['22', 1, 100, 'Retención del 100%', '731','02']);
        DB::insert('insert into cat_retention_types (id, active, percentage, description, code, type_id) values (?, ?, ?, ?, ?, ?)', ['23', 1, 2.75, 'Retencion Aplicables 2%', '3440','01']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
