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
        Schema::create('twitter_user_data', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0);
            $table->string('data', 7168)->default('');
            $table->integer('insert_flag')->default(0);
            $table->timestamps();
			$table->unique(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('twitter_user_data');
    }
};
