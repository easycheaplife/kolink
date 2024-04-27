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
        Schema::create('kol', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64)->default('')->unique('unique_token');
            $table->string('email', 128)->default('');
            $table->bigInteger('twitter_user_id')->default(0);
            $table->string('twitter_user_name', 64)->default('');
            $table->string('twitter_avatar', 512)->default('');
            $table->integer('twitter_followers')->default(0);
            $table->integer('twitter_subscriptions')->default(0);
            $table->integer('twitter_friends_count')->default(0);
            $table->integer('twitter_favourites_count')->default(0);
            $table->integer('twitter_listed_count')->default(0);
            $table->integer('twitter_statuses_count')->default(0);
            $table->integer('twitter_media_count')->default(0);
            $table->integer('twitter_created_at')->default(0);
            $table->integer('region_id')->default(0)->default(0);
            $table->integer('language_id')->default(0);
            $table->string('category_id', 64)->default('');
            $table->integer('channel_id')->default(0);
            $table->string('monetary_score', 24)->default('');
            $table->string('engagement_score', 24)->default('');
            $table->string('age_score', 24)->default('');
            $table->string('composite_score', 24)->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kol');
    }
};
