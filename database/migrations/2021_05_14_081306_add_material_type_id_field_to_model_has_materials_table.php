<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaterialTypeIdFieldToModelHasMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_has_materials', function (Blueprint $table) {
            $table->foreignId('material_type_id')->nullable()->constrained('material_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('model_has_materials', function (Blueprint $table) {
            $table->dropColumn(['material_type_id']);
        });
    }
}
