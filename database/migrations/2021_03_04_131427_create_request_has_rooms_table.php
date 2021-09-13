<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestHasRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_has_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->nullable()->constrained('requests')->onDelete('cascade');
            $table->foreignId('room_type_id')->nullable()->constrained('request_room_types')->onDelete('cascade');
            $table->foreignId('renovation_type_id')->nullable()->constrained('request_renovation_types')->onDelete('cascade');
            $table->string('size')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('request_rooms');
    }
}
