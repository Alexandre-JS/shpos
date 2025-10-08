<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\CategorySeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Usuário de teste
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Categorias iniciais
        $this->call(CategorySeeder::class);
    }
}
