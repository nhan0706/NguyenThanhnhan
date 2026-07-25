<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $products = Product::all();

        if ($orders->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach ($orders as $order) {
            $itemCount = rand(1, 4);
            $totalAmount = 0;

            // Randomly select unique products for each order's items
            $selectedProducts = $products->random(min($itemCount, $products->count()));
            
            // Ensure we deal with a collection
            if ($selectedProducts instanceof Product) {
                $selectedProducts = collect([$selectedProducts]);
            }

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 3);
                // Use pricediscount if available, otherwise regular price
                $price = ($product->pricediscount > 0) ? $product->pricediscount : $product->price;
                $subtotal = $price * $quantity;
                $totalAmount += $subtotal;

                DB::table('order_items')->insert([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'created_at' => $order->created_at,
                    'updated_at' => now(),
                ]);
            }

            // Update order's total amount
            $order->update(['total_amount' => $totalAmount]);
        }
    }
}
