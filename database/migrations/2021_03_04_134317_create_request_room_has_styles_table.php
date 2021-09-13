<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestRoomHasStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_room_has_styles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained('request_has_rooms')->onDelete('cascade');
            $table->foreignId('style_id')->nullable()->constrained('request_room_styles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_has_room_styles');
    }
}
