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
        Schema::create('tweet', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tweet_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->string('user_name', 64)->default('');
            $table->string('full_text', 8192)->default('');
            $table->integer('favorite_count')->default(0);
            $table->integer('reply_count')->default(0);
            $table->integer('retweet_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->timestamps();
			$table->unique(['tweet_id']);
			$table->index('user_id');
			$table->index('user_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweet');
    }
};
