<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachmentUsageTypeToModelHasAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('model_has_attachments', function (Blueprint $table) {
            $table->foreignId('attachment_type_id')->after('model_id')->nullable()->constrained('attachment_usage_types')->onDelete('cascade');
            $table->index(['attachment_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('model_has_attachments', function (Blueprint $table) {
            $table->dropColumn('attachment_type_id');
        });
    }
}
