<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaticDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * For first time install of App
     */
    public function run(): void
    {
        // Insert Default Roles
        Role::insert([
            [
                'id' => 1,
                'name' => 'Contributor',
            ],
            [
                'id' => 2,
                'name' => 'Normal User',
            ]
        ]);

        // Insert Default Categories
        Category::insert([
            [
                'title' => 'Technology',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Marketing',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'B2B',
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);





    }
}
