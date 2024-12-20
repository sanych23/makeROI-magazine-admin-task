<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for($count=0; $count < 30; $count++){
            DB::table('products')->insert([
                [
                    'id' => $faker->uuid(),
                    'name' => $faker->text(20),
                    'description' => $faker->text(150),
                    'price' => $faker->numberBetween(100, 1000000),
                ]
            ]);
        }
    }
}
