<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestRoomHasWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_room_has_works', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->nullable()->constrained('request_has_rooms')->onDelete('cascade');
            $table->foreignId('work_type_id')->nullable()->constrained('request_work_types')->onDelete('cascade');
            $table->foreignId('work_action_id')->nullable()->constrained('request_work_actions')->onDelete('cascade');
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
        Schema::dropIfExists('request_room_works');
    }
}
