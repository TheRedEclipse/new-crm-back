<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeIdToRequestWorkReplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_work_replaces', function (Blueprint $table) {
            $table->foreignId('type_id')->after('room_type_id')->nullable()->constrained('request_work_replace_types')->onDelete('cascade');
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
