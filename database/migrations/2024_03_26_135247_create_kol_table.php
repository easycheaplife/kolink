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
            $table->string('token', 64);
            $table->string('email', 64);
            $table->string('twitter_user_name', 64);
            $table->integer('twitter_followers');
            $table->integer('twitter_subscriptions');
            $table->integer('region_id');
            $table->integer('category_id');
            $table->string('website', 128);
            $table->integer('language_id');
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
