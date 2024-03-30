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
        Schema::create('project_task_application', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id');
            $table->integer('kol_id');
            $table->float('quotation');
            $table->integer('status')->default(0);
            $table->string('reason')->default('');
            $table->string('comment')->default('');
            $table->timestamps();
			$table->unique(['kol_id', 'task_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_task_application');
    }
};
