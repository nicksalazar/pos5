<?php

use App\Models\System\ModuleLevel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModulePurchasesType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('modules', function (Blueprint $table) {
            //
            $q2 = new ModuleLevel([
                                    'value'       => 'purchases_types',
                                    'description' => 'Tipos documentos de compras ',
                                ]);
            $q2->setModuleId(2)->push();
        });
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
