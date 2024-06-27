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
        Schema::create('recommend_task', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id')->default(0)->unique('unique_task_id');
            $table->string('url', 128)->default('');
            $table->integer('enable')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommend_task');
    }
};
