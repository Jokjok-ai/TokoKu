<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada minimal 1 kategori
        if (Category::count() == 0) {
            Category::create([
                'name' => 'Uncategorized'
            ]);
        }

        $category = Category::first();

        // Insert beberapa barang
        Item::insert([
            [
                'name' => 'Pensil',
                'category_id' => $category->id,
                'stock' => 100,
                'unit' => 'pcs',
                'price' => 2000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Buku Tulis',
                'category_id' => $category->id,
                'stock' => 150,
                'unit' => 'pcs',
                'price' => 5000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pulpen',
                'category_id' => $category->id,
                'stock' => 80,
                'unit' => 'pcs',
                'price' => 3000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
