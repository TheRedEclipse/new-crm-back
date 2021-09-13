<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditSlideTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slide_types', function (Blueprint $table) {
            $table->string('type')->nullable()->change();
            $table->renameColumn('type', 'title');
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slide_types', function (Blueprint $table) {
            $table->string('title')->nullable(false)->change();
            $table->renameColumn('title', 'type');
            $table->dropColumn(['name']);
        });
    }
}
