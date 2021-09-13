<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditFieldsInMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['dimension', 'tag']);
            $table->double('height')->nullable();
            $table->double('width')->nullable();
            $table->double('length')->nullable();
            $table->double('weight')->nullable();
            $table->text('demension_description')->nullable();
            $table->double('rating')->nullable();
            $table->integer('sort')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->text('dimension')->nullable();
            $table->text('tag')->nullable();
            $table->dropColumn(['height', 'width', 'length', 'weight', 'demension_description', 'sort']);
        });
    }
}
