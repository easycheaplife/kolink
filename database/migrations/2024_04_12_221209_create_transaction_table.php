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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->string('index_code', 32)->default('');
            $table->integer('transaction_type')->default(0);
            $table->integer('block_number')->default(0);
            $table->string('from_address', 64)->default('');
            $table->string('to_address', 64)->default('');
            $table->string('token', 64)->default('');
            $table->bigInteger('amt')->default(0);
            $table->bigInteger('fee')->default(0);
            $table->integer('transaction_time')->default(0);
            $table->integer('created_time')->default(0);
			$table->unique(['block_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
