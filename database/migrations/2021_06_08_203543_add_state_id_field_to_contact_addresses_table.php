<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStateIdFieldToContactAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_addresses', function (Blueprint $table) {
            $table->foreignId('state_id')->after('id')->nullable()->constrained('states');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_addresses', function (Blueprint $table) {
            $table->dropForeign('state_id_foreign');
            $table->dropColumn(['state_id']);
        });
    }
}
