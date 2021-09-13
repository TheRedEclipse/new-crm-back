<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('created_by_id')->constrained('users')->onDelete('cascade');
            $table->string('lead_referral_source')->nullable();
            $table->string('title')->nullable();
            $table->string('company')->nullable();
            $table->string('industry')->nullable();
            $table->string('phone')->nullable();
            $table->foreignId('status_id')->nullable()->constrained('statuses')->onDelete('cascade')->comment('Статус субконтрактора');
            $table->integer('rating')->nullable();
            $table->string('project_type')->nullable();
            $table->text('project_description')->nullable();
            $table->double('budget')->nullable();
            $table->double('current_estimate_budget')->nullable();
            $table->timestamp('contact_initialized_at')->nullable();
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
        Schema::dropIfExists('leads');
    }
}
