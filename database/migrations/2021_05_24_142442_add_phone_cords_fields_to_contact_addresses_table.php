<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneCordsFieldsToContactAddressesTable extends Migration
{
    /**
     * Run the migrations.
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact_addresses', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
            $table->dropColumn(['phone', 'latitude', 'longitude']);
        });
    }
}
