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
        Schema::create('project_task_viewer', function (Blueprint $table) {
            $table->id();
            $table->integer('kol_id')->default(0);
            $table->integer('project_id')->default(0);
            $table->integer('task_id')->default(0);
            $table->string('avatar', 512)->default('');
            $table->timestamps();
			$table->unique(['kol_id', 'project_id', 'task_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_task_viewer');
    }
};
