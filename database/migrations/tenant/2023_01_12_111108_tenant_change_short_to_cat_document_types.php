<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TenantChangeShortToCatDocumentTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('cat_document_types')->where('id', '14')->update(['short' => 'CO']);
        DB::table('cat_document_types')->where('id', '04')->update(['short' => 'CO']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('cat_document_types')->where('id', '14')->update(['short' => 'CO']);
        DB::table('cat_document_types')->where('id', '04')->update(['short' => 'CO']);
    }
}
