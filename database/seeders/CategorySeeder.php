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
        Category::create([
            'name'=>'Men\'s Fashion',
        ]);
        Category::create([
            'name'=>'Women\'s Fashion',
        ]);
        Category::create([
            'name'=>'Books',
        ]);
        Category::create([
            'name'=>'Home, Kitchen, Pets',
        ]);
        Category::create([
            'name'=>'Mobile Computers',
        ]);
        Category::create([
            'name'=>'Beauty, Heath, Grocery',
        ]);
        Category::create([
            'name'=>'Tv. Electronics',
        ]);
    }
}
