<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->string('ip_address', 45);
            $table->string('user_agent', 500)->nullable();
            $table->timestamp('created_at')->useCurrent(); // conforme especificação (só created_at)

            $table->index('product_id');
            $table->index('created_at');
            // Poderemos futuramente adicionar índice composto (product_id, created_at) para relatórios
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('views');
    }
};
