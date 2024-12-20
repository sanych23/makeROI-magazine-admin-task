<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderPosition;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $orders = Order::all();

        for ($count = 0; $count < 30; $count++) {
            OrderPosition::create([
                "product_id" => $products->pop()->id,
                'order_id' => $orders->random()->id,
                'count' => rand(0, 10)
            ]);
        }
    }
}
