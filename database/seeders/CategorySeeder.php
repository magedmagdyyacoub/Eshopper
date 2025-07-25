<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'image_url' => 'uploads/categories/electronics.jpg',
            ],
            [
                'name' => 'Fashion',
                'image_url' => 'uploads/categories/fashion.jpg',
            ],
            [
                'name' => 'Home Appliances',
                'image_url' => null, // No image for this category
            ],
            [
                'name' => 'Sports',
                'image_url' => 'uploads/categories/sports.jpg',
            ],
            [
                'name' => 'Books',
                'image_url' => null, // No image for this category
            ],
            [
                'name' => 'Beauty & Health',
                'image_url' => 'uploads/categories/beauty_health.jpg',
            ],
            [
                'name' => 'Toys & Hobbies',
                'image_url' => null, // No image for this category
            ],
            [
                'name' => 'Automotive',
                'image_url' => 'uploads/categories/automotive.jpg',
            ],
            [
                'name' => 'Groceries',
                'image_url' => null, // No image for this category
            ],
            [
                'name' => 'Furniture',
                'image_url' => 'uploads/categories/furniture.jpg',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
