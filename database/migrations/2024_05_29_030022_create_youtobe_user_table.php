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
        Schema::create('youtube_user', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 64)->default(0);
            $table->string('title', 128)->default('');
            $table->string('profile_image_url', 256)->default('');
            $table->string('description', 512)->default('');
            $table->string('custom_url', 64)->default('');
            $table->integer('view_count')->default(0);
            $table->integer('subscriber_count')->default(0);
            $table->integer('video_count')->default(0);
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
        Schema::dropIfExists('youtube_user');
    }
};
