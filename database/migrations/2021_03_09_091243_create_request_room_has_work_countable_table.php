<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestRoomHasWorkCountableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_room_has_work_countable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained('request_has_rooms')->onDelete('cascade');
            $table->foreignId('countable_type_id')->nullable()->constrained('request_work_countable_types')->onDelete('cascade');
            $table->integer('count')->default(0);
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
        Schema::dropIfExists('request_room_has_work_countable');
    }
}
