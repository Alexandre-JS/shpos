<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->constrained('entities')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories'); // restrito (RESTRICT por padrão)
            $table->string('name', 255);
            $table->string('slug', 255); // unique per entity
            $table->text('description');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('image_path', 500)->nullable();
            $table->enum('type', ['product', 'service'])->index();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('views_count')->default(0)->index();
            $table->timestamps();

            // Índices específicos
            $table->index(['entity_id']);
            $table->index(['category_id']);
            $table->index(['created_at']);
            $table->unique(['entity_id', 'slug'], 'idx_entity_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
