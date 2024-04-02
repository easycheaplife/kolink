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
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64);
            $table->string('email', 64)->unique('unique_email');
            $table->string('logo', 64);
            $table->string('twitter_user_name', 64);
            $table->string('name', 64);
            $table->string('desc', 64);
            $table->string('website', 128);
            $table->string('category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
