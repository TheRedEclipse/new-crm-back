<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConstrainedInRequestWorkReplaces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_work_replaces', function (Blueprint $table) {
            $table->dropForeign('request_work_sub_types_room_type_id_foreign');
            $table->dropColumn('room_type_id');
        });

        Schema::table('request_work_replaces', function (Blueprint $table) {
            $table->foreignId('room_type_id')->after('id')->nullable()->constrained('request_room_types')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_work_replaces', function (Blueprint $table) {
            //
        });
    }
}
