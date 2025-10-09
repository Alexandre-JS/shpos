<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('discount_type', ['percent', 'amount'])->nullable()->after('price');
            $table->decimal('discount_value', 10, 2)->nullable()->after('discount_type');
            $table->timestamp('discount_starts_at')->nullable()->after('discount_value');
            $table->timestamp('discount_ends_at')->nullable()->after('discount_starts_at');

            $table->index(['discount_starts_at']);
            $table->index(['discount_ends_at']);
            $table->index(['discount_type']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['discount_starts_at']);
            $table->dropIndex(['discount_ends_at']);
            $table->dropIndex(['discount_type']);
            $table->dropColumn([
                'discount_type',
                'discount_value',
                'discount_starts_at',
                'discount_ends_at',
            ]);
        });
    }
};
