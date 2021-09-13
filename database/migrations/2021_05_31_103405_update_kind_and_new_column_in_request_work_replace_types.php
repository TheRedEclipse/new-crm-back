<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateKindAndNewColumnInRequestWorkReplaceTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_work_replace_types', function (Blueprint $table) {
            $table->renameColumn('kind', 'name');
        });
        Schema::table('request_work_replace_types', function (Blueprint $table) {
            $table->string('title')->after('name')->nullable();
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_work_replace_types', function (Blueprint $table) {
            $table->renameColumn('name', 'kind');
        });
    }
}
