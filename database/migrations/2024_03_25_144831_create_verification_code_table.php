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
        Schema::create('verification_code', function (Blueprint $table) {
            $table->id();
            $table->string('email', 128)->default('');
            $table->integer('code')->default(0);
            $table->integer('send_flag')->default(0);
            $table->integer('try_times')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_code');
    }
};
