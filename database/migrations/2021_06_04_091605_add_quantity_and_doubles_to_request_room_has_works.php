<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityAndDoublesToRequestRoomHasWorks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_room_has_works', function (Blueprint $table) {
            $table->integer('quantity')->after('work_action_id')->nullable();
            $table->foreignId('double_current_id')->after('quantity')->nullable()->constrained('request_work_replaces')->onDelete('cascade');
            $table->foreignId('double_replace_id')->after('double_current_id')->nullable()->constrained('request_work_replaces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_room_has_works', function (Blueprint $table) {
            //
        });
    }
}
