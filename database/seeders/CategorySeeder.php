<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $categories = [
            'Fiction',
            'Non-Fiction',
            'Romance',
            'Science Fiction',
            'Fantasy',
            'Thriller',
            'Mystery',
            'Biography',
            'History',
            'Self-Help',
            'Children\'s Books',
            'Educational',
            'Business',
            'Health & Wellness',
            'Poetry',
            'Religion',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
