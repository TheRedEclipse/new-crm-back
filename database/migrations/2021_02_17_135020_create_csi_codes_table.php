<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsiCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csi_codes', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('level');
            $table->string('code');
            $table->string('name');
            $table->foreignId('parent_id')->constrained('csi_codes')->onDelete('cascade');
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
        Schema::dropIfExists('csi_codes');
    }
}
