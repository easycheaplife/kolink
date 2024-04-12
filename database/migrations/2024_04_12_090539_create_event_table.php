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
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string('index_code')->default('');
            $table->integer('event_type')->default(0);
            $table->integer('block_number')->default(0);
            $table->string('from_address')->default('');
            $table->string('to_address')->default('');
            $table->string('token')->default('');
            $table->bigInteger('amt')->default(0);
            $table->integer('created_time')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
