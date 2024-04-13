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
            $table->integer('task_id')->default(0);
            $table->integer('kol_id')->default(0);
            $table->float('quotation')->default(0.0);
            $table->integer('status')->default(0);
            $table->string('reason', 128)->default('');
            $table->string('comment', 128)->default('');
            $table->string('verification', 128)->default('');
            $table->string('url', 128)->default('');
            $table->string('web3_hash', 32)->default('');
            $table->timestamps();
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
