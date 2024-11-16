<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Datos iniciales para la tabla 'categories'
        $categories = [
            ['name' => 'Tecnología', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Ciencia', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Salud', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Entretenimiento', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Deportes', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Educación', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Arte y Cultura', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Negocios', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Viajes', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Opinión', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);
    }
}
