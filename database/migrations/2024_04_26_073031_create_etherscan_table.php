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
        Schema::create('etherscan', function (Blueprint $table) {
            $table->id();
			$table->string('address', 64)->default('')->unique('unique_address');
            $table->integer('token_count')->default(0);
            $table->integer('nft_count')->default(0);
            $table->integer('created_at')->default(0);
            $table->integer('updated_at')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etherscan');
    }
};
