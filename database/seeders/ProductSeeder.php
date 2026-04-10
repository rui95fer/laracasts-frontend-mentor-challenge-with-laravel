<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = json_decode(file_get_contents(database_path('seeders/data.json')), true);

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'category' => $product['category'],
                'price' => $product['price'],
                'image' => basename($product['image']['mobile']),
            ]);
        }
    }
}
