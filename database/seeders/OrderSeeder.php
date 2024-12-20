<?php

namespace Database\Seeders;

use App\Enums\OrderStatusType;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    const STATUS_ENUM = [
        "REGISTRATION",
        "DELIVERY",
        "SUCCESS"
    ];

    public function run(): void
    {
        $faker = Faker::create();

        for($count=0; $count < 10; $count++){
            DB::table('orders')->insert([
                [
                    'user_id' => User::inRandomOrder()->first()->id,
                    'status' => OrderStatusType::getRandomValue(),
                ]
            ]);
        }
    }
}
