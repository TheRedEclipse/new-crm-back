<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesForModelHasRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_has_rooms', function (Blueprint $table) {
            $table->index(['model_id', 'model_type'], 'model_has_rooms_model_id_model_type_index');
            $table->primary(['room_id', 'model_id', 'model_type'], 'model_has_rooms_room_model_type_primary');
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
