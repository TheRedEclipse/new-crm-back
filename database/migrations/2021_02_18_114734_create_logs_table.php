<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('to_user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('ip')->nullable();
            $table->string('message')->nullable();
            $table->string('user_message')->nullable();
            $table->double('count')->default(0);
            $table->foreignId('type_id')->nullable()->constrained('log_types')->onDelete('cascade');
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
        Schema::dropIfExists('logs');
    }
}
