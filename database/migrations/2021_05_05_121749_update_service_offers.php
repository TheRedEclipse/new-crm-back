<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateServiceOffers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_offers', function (Blueprint $table) {
            $table->dropColumn('block_title');
            $table->dropColumn('block_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_offers', function (Blueprint $table) {
            $table->string('block_title')->nullable();
            $table->text('block_description')->nullable();
        });
    }
}
