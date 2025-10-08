<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Moda & Beleza', 'type' => 'both', 'icon' => '💄'],
            ['name' => 'Alimentos & Bebidas', 'type' => 'product', 'icon' => '🍔'],
            ['name' => 'Tecnologia & Eletrónicos', 'type' => 'product', 'icon' => '💻'],
            ['name' => 'Casa & Construção', 'type' => 'both', 'icon' => '🏠'],
            ['name' => 'Serviços Profissionais', 'type' => 'service', 'icon' => '🛠️'],
            ['name' => 'Saúde & Bem-estar', 'type' => 'both', 'icon' => '🧘'],
            ['name' => 'Educação & Cursos', 'type' => 'service', 'icon' => '🎓'],
            ['name' => 'Eventos & Entretenimento', 'type' => 'service', 'icon' => '🎉'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'type' => $cat['type'],
                    'icon' => $cat['icon'],
                    'is_active' => true,
                ]
            );
        }
    }
}
