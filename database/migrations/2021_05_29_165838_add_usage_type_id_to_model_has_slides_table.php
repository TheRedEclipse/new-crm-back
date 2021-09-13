<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsageTypeIdToModelHasSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_has_slides', function (Blueprint $table) {
            $table->foreignId('usage_type_id')->nullable()->constrained('slide_usage_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('model_has_slides', function (Blueprint $table) {
            $table->dropForeign('model_has_slides_usage_type_id_foreign');
            $table->dropColumn(['usage_type_id']);
        });
    }
}
