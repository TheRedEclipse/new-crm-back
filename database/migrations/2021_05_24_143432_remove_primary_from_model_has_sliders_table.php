<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemovePrimaryFromModelHasSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('model_has_sliders');

        Schema::create('model_has_sliders', function (Blueprint $table) {
            $table->foreignId('slider_id')->nullable()->constrained('sliders')->onDelete('cascade');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->foreignId('type_id')->nullable()->constrained('slider_types')->onDelete('cascade');
            $table->integer('sort')->nullable();
            $table->index(['model_id', 'model_type']);
            $table->softDeletes();
            $table->timestamps();
        });
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
