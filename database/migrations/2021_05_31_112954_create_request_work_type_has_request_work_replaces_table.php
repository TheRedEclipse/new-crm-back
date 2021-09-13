<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestWorkTypeHasRequestWorkReplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_work_type_has_request_work_replaces', function (Blueprint $table) {
            $table->foreignId('replace_id', 'work_type_has_work_replace')->nullable()->constrained('request_work_replaces')->onDelete('cascade');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type'], 'work_type_has_work_replace');
            $table->foreignId('type_id', 'work_type_has_work_replace_type')->nullable()->constrained('request_work_replace_types')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_work_type_has_request_work_replaces');
    }
}
