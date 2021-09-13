<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialPlatfromAndUserRelationshipToReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('reviews', 'user_id'))
        {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign('reviews_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }

        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained('users');
            $table->foreignId('social_platform_id')->after('user_id')->nullable()->constrained('social_platforms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            //
        });
    }
}
