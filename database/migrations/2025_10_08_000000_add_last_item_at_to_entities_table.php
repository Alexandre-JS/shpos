<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->timestamp('last_item_at')->nullable()->after('plan_type');
            $table->index(['is_active', 'last_item_at']);
        });

        // Backfill inicial
        $driver = DB::getDriverName();
        if ($driver === 'sqlite') {
            // SQLite não permite alias após UPDATE simples.
            DB::statement(
                "UPDATE entities SET last_item_at = (
                    SELECT MAX(p.created_at) FROM products p WHERE p.entity_id = entities.id AND p.is_active = 1
                )"
            );
        } else {
            DB::statement(
                "UPDATE entities e SET last_item_at = (
                    SELECT MAX(p.created_at) FROM products p WHERE p.entity_id = e.id AND p.is_active = 1
                )"
            );
        }
    }

    public function down(): void
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'last_item_at']);
            $table->dropColumn('last_item_at');
        });
    }
};
