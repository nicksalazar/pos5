<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantModifyCodeAndTypeToCatRetentionTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('cat_retention_types')->where('id', '01')->update(['code' => '1']);
        DB::table('cat_retention_types')->where('id', '01')->update(['type_id' => '02']);
        DB::table('cat_retention_types')->where('id', '02')->update(['code' => '2']);
        DB::table('cat_retention_types')->where('id', '02')->update(['type_id' => '02']);
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
