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
            $table->integer('kol_id');
            $table->integer('task_id');
            $table->string('avatar', 64);
			$table->unique(['kol_id', 'task_id']);
            $table->timestamps();
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
