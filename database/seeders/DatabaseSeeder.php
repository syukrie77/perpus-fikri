<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $categories = ['Fiksi', 'Sains', 'Sejarah', 'Teknologi', 'Bisnis', 'Biografi'];
        foreach($categories as $c) {
            \App\Models\Category::create(['name' => $c]);
        }

        User::factory()->create([
            'name' => 'Admin Perpustakaan',
            'email' => 'admin@perpustakaan.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
    }
}
