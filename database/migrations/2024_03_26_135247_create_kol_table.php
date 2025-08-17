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
            $table->string('twitter_tweet_summarize', 1024)->default('');
            $table->integer('twitter_followers')->default(0);
            $table->integer('twitter_like_count')->default(0);
            $table->integer('twitter_following_count')->default(0);
            $table->integer('twitter_listed_count')->default(0);
            $table->integer('twitter_statuses_count')->default(0);
            $table->integer('twitter_favorite_count_total')->default(0);
            $table->integer('twitter_reply_count_total')->default(0);
            $table->integer('twitter_retweet_count_total')->default(0);
            $table->integer('twitter_view_count_total')->default(0);
            $table->integer('twitter_created_at')->default(0);
            $table->string('youtube_user_id', 64)->default('');
            $table->string('youtube_user_name', 64)->default('');
            $table->string('youtube_avatar', 512)->default('');
            $table->string('youtube_custom_url', 64)->default('');
            $table->integer('youtube_subscriber_count')->default(0);
            $table->integer('youtube_view_count')->default(0);
            $table->integer('youtube_video_count')->default(0);
            $table->integer('youtube_created_at')->default(0);
            $table->string('region_id', 64)->default('');
            $table->string('language_id', 64)->default('');
            $table->string('category_id', 64)->default('');
            $table->integer('channel_id', 64)->default('');
            $table->string('monetary_score', 24)->default('');
            $table->string('engagement_score', 24)->default('');
            $table->string('age_score', 24)->default('');
            $table->string('composite_score', 24)->default('');
            $table->string('invite_code', 24)->default('');
            $table->string('invitee_code', 24)->default('');
            $table->integer('xp')->default(0);
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
