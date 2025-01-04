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
            ['name' => 'Electronics', 'description' => 'Devices and gadgets like phones, laptops, and cameras.'],
            ['name' => 'Clothing', 'description' => 'Men\'s and Women\'s fashion wear.'],
            ['name' => 'Sports', 'description' => 'Equipment and gear for various sports activities.'],
            ['name' => 'Home & Kitchen', 'description' => 'Appliances and essentials for home and kitchen use.'],
            ['name' => 'Books', 'description' => 'Fiction, non-fiction, and educational books.'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}
