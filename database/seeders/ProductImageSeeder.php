<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all products to link images to
        $products = Product::all();
        if ($products->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 30; $i++) {
            $product = $products->random();
            DB::table('product_images')->insert([
                'product_id' => $product->id,
                'image' => 'product-detail-' . rand(1, 10) . '.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
