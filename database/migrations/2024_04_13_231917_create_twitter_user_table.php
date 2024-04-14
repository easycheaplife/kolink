<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('twitter_user', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0);
            $table->string('name', 128)->default('');
            $table->string('screen_name', 128)->default('');
            $table->string('location', 256)->default('');
            $table->string('description', 512)->default('');
            $table->string('url', 512)->default('');
            $table->integer('followers_count')->default(0);
            $table->integer('friends_count')->default(0);
            $table->integer('listed_count')->default(0);
            $table->integer('favourites_count')->default(0);
            $table->integer('following_count')->default(0);
            $table->string('description_urls', 512)->default('');
            $table->integer('media_count')->default(0);
            $table->integer('utc_offset')->default(0);
            $table->string('time_zone', 128)->default('');
            $table->integer('geo_enabled')->default(0);
            $table->integer('verified')->default(0);
            $table->integer('statuses_count')->default(0);
            $table->string('lang', 128)->default('');
            $table->string('profile_background_image_url', 256)->default('');
            $table->string('profile_background_image_url_https', 256)->default('');
            $table->string('profile_image_url', 256)->default('');
            $table->string('profile_image_url_https', 256)->default('');
            $table->integer('created_at')->default(0);
            $table->integer('updated_at')->default(0);
			$table->unique(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twitter_user');
    }
};
