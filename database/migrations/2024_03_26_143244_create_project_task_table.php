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
        Schema::create('project_task', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('title', 64);
            $table->string('desc', 64);
            $table->integer('social_platform_id');
            $table->integer('kol_max');
            $table->integer('kol_min_followers');
            $table->integer('kol_like_min');
            $table->integer('kol_socre_min');
            $table->integer('start_time');
            $table->integer('applition_ddl_time');
            $table->integer('upload_ddl_time');
            $table->integer('blockchain_id');
            $table->integer('token_id');
            $table->integer('reward_min');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_task');
    }
};
