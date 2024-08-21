<?php

use Illuminate\Database\Migrations\Migration;
us_ IlluminaeeeDatabase\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('twitter_content_relevance', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0);
            $table->string('user_name', 64)->default('');
            $table->integer('category_id')->default(0);
            $table->integer('score')->default(0);
            $table->string('explanation', 2048)->default('');
            $table->timestamps();
			$table->unique(['user_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twitter_content_relevance');
    }
};
