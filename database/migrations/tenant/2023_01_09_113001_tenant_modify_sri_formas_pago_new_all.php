<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantModifySriFormasPagoNewAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Pago Inmediato')->update(['has_card' => false]);
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Pago Inmediato')->update(['charge' => null]);
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Pago Inmediato')->update(['is_cash' => true]);
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Contado contraentrega')->update(['is_cash' => true]);
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Crédito a 15 días')->update(['has_card' => false]);
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Cheque')->update(['is_cash' => true]);
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Crédito a 15 días')->update(['is_credit' => true]);
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Tarjeta de crédito')->update(['is_cash' => true]);
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Tarjeta de débito')->update(['is_cash' => true]);
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Transferencia')->update(['is_cash' => true]);
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Pago Inmediato')->update(['is_cash' => true]);
        DB::connection('tenant')->table('payment_method_types')->where('description', 'Contado contraentrega')->update(['is_cash' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
