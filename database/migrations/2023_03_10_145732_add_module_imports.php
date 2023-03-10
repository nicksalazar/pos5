<?php

use App\Models\System\Module;
use App\Models\System\ModuleLevel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModuleImports extends Migration
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
            $e = new Module([
                                'value'       => 'imports',
                                'sort'        => 13,
                                'description' => 'Importaciones',
                            ]);
            $e->setSort(13)->push();

            $q = new ModuleLevel([
                                     'value'       => 'folder',
                                     'description' => 'Carpeta Importaciones',
                                 ]);
            $q->setModuleId($e->id)->push();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $e = Module::where([
            'description' => 'Importaciones',
            'value'       => 'imports',
        ])->first();
        if (!empty($e)) {
            $id = $e->id;
            $e->delete();
            $q = ModuleLevel::where('module_id', $id)->get();
            foreach ($q as $i) {
            $i->delete();
        }

        }
    }
}
