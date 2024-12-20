<?php

namespace Database\Seeders;

use App\Models\OrderPosition;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    //TODO: Поинтересоваться про правильность заполнения сидов
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            OrderPositionSeeder::class
        ]);
    }
}
