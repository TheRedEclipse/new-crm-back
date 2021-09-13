<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndSortToModelHasSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_has_sliders', function (Blueprint $table) {
            $table->foreignId('type_id')->after('model_id')->nullable()->constrained('slider_types')->onDelete('cascade');
            $table->integer('sort')->after('type_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('model_has_sliders', function (Blueprint $table) {
            //
        });
    }
}
