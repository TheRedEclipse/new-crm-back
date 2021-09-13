<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('status_id')->nullable()->constrained('statuses')->onDelete('cascade')->comment('Статус субконтрактора');
            $table->foreignId('stage_id')->nullable()->constrained('request_stages')->onDelete('cascade')->comment('Состояние реквеста?');
            $table->foreignId('project_stage_date_id')->nullable()->constrained('project_stage_dates')->onDelete('cascade');
            $table->foreignId('building_type_id')->nullable()->constrained('building_types')->onDelete('cascade')->comment('Тип здания');
            $table->foreignId('building_stage_id')->nullable()->constrained('building_stages')->onDelete('cascade');
            $table->text('request_information')->nullable();
            $table->timestamp('attachment_link_sent_at')->nullable();
            $table->timestamp('project_started_at')->nullable();
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
        Schema::dropIfExists('requests');
    }
}
