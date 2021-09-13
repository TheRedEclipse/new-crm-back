<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestRoomStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_room_styles', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->integer('sort')->nullable();
            $table->boolean('is_checked')->default(false);
            $table->foreignId('room_type_id')->nullable()->constrained('request_room_types')->onDelete('cascade');
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
        Schema::dropIfExists('request_room_styles');
    }
}
