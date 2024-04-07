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
            $table->string('token', 64)->default('');
            $table->string('email', 128)->default('')->unique('unique_email');
            $table->string('logo', 128)->default('');
            $table->string('twitter_user_name', 64)->default('');
            $table->string('name', 64)->default('');
            $table->string('desc', 64)->default('');
            $table->string('website', 128)->default('');
            $table->string('category_id', 64)->default('');
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
