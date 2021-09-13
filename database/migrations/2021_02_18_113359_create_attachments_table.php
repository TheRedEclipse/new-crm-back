<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('attachment_usage_type_id')->nullable()->constrained('attachment_usage_types');
            $table->string('path');
            $table->string('url');
            $table->string('type');
            $table->text('description')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('statuses')->onDelete('cascade');
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
        Schema::dropIfExists('attachments');
    }
}
