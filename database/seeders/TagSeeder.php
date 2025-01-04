<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Manual Tags
        $tags = [
            'Sports', 'Regular', 'Seasonal', 'Luxury', 'Sale', 
            'Trending', 'New Arrival', 'Limited Edition', 
            'Eco-Friendly', 'Handmade'
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['name' => $tag]);
        }
    }
}
