<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestWorkCountableTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_work_countable_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_type_id')->nullable()->constrained('request_work_types')->onDelete('cascade');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('icon')->nullable();
            $table->integer('min')->default(0);
            $table->integer('max')->default(99);
            $table->integer('sort')->nullable();
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
        Schema::dropIfExists('request_work_countable_types');
    }
}
