<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWidthHeightLengthToRequestHasRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_has_rooms', function (Blueprint $table) {
            $table->dropColumn('size');
        });
        Schema::table('request_has_rooms', function (Blueprint $table) {
            $table->double('length')->after('renovation_type_id');
            $table->double('width')->after('length');
            $table->double('height')->after('width');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_has_rooms', function (Blueprint $table) {
            //
        });
    }
}
