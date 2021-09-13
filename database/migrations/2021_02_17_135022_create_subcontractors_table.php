<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubcontractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcontractors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('Связь с пользователем');
            $table->string('company_name')->nullable()->comment('Название компании');
            $table->string('primary_contact_name')->nullable()->comment('Имя главной персоны');
            $table->string('phone')->nullable()->comment('Телефон');
            $table->foreignId('type_id')->nullable()->constrained('subcontractor_types')->onDelete('cascade')->comment('Тип субконтрактора');
            $table->foreignId('vendor_source_id')->nullable()->constrained('subcontractor_vendor_sources')->onDelete('cascade')->comment('Родительский субконтрактор');
            $table->foreignId('parent_id')->nullable()->constrained('subcontractors')->onDelete('cascade')->comment('Родительский субконтрактор');
            $table->foreignId('status_id')->nullable()->constrained('statuses')->onDelete('cascade')->comment('Статус субконтрактора');
            $table->string('website')->nullable()->comment('Сайт');
            $table->boolean('has_project')->nullable();
            $table->boolean('workers_compensation')->nullable();
            $table->boolean('licensed')->nullable();
            $table->boolean('general_liability')->nullable();
            $table->text('crew_size')->nullable();
            $table->text('languages')->nullable();
            $table->boolean('drivers_license')->nullable();
            $table->boolean('has_tools')->nullable();
            $table->boolean('has_vehicle')->nullable();
            $table->integer('years_of_experience')->nullable();
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
        Schema::dropIfExists('subcontractors');
    }
}
