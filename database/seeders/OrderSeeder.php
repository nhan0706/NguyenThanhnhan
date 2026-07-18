<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        if ($customers->isEmpty()) {
            return;
        }

        for ($i = 1; $i <= 25; $i++) {
            $customer = $customers->random();
            DB::table('orders')->insert([
                'customer_id' => $customer->id,
                'status_id' => rand(1, 5),
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'total_amount' => 0, // Will be updated by OrderItemSeeder or set directly
                'payment_method' => rand(0, 1) ? 'cod' : 'vnpay',
                'payment_status' => rand(0, 1) ? 'unpaid' : 'paid',
                'note' => fake()->sentence(),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
        }
    }
}
