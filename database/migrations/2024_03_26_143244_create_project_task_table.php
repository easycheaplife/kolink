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
            $table->integer('project_id')->default(0);
            $table->string('title', 512)->default('');
            $table->string('desc', 2048)->default('');
            $table->string('backgroud_image', 512)->default('');
            $table->integer('social_platform_id')->default(0);
            $table->integer('kol_max')->default(0);
            $table->integer('kol_min_followers')->default(0);
            $table->integer('kol_like_min')->default(0);
            $table->integer('kol_score_min')->default(0);
            $table->integer('kol_view_min')->default(0);
            $table->integer('kol_subscribers_min')->default(0);
            $table->integer('start_time')->default(0);
            $table->integer('applition_ddl_time')->default(0);
            $table->integer('upload_ddl_time')->default(0);
            $table->integer('blockchain_id')->default(0);
            $table->integer('token_id')->default(0);
            $table->integer('reward_min')->default(0);
            $table->integer('close')->default(0);
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
