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
        Schema::create('transaction_queue', function (Blueprint $table) {
            $table->id();
            $table->string('index_node', 32)->default('');
            $table->integer('transaction_type')->default(0);
            $table->integer('transaction_flag')->default(0);
            $table->integer('transaction_try_times')->default(0);
			$table->unique(['index_node', 'transaction_type']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_queue');
    }
};
