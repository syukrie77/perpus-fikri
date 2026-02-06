<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Non-Fiksi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sains', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Teknologi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sejarah', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Biografi', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Anak-anak', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pelajaran', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('categories')->insert($categories);
    }
}
