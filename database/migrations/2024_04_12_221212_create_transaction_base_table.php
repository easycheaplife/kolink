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
        Schema::create('transaction_base', function (Blueprint $table) {
            $table->id();
			$table->integer('blockchain_id')->default(0);
			$table->integer('last_block_number')->default(0);
			$table->string('rpc_url', 128)->default('');
			$table->string('contract_addr', 128)->default('');
			$table->string('private_key', 128)->default('');
			$table->unique(['blockchain_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_base');
    }
};
