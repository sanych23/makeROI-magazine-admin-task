<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $faker = Faker::create();

        DB::table('users')->insert([
            [
                'id' => "524565c0-6820-3d19-8589-8ae10ab7b169",
                'name' => 'admin',
                'email' => 'sansanych@mail.ru',
                'password' => '$2y$12$udcmXAm0noQP3.7lAlijFuUNVPhkp86J4n/zfBLYsrlO5XPwRHFOy',
                'phone' => $faker->phoneNumber(),
                'birthday' => Carbon::now(),
                'permissions' => '{"platform.index": true, "platform.systems.roles": true, "platform.systems.users": true, "platform.systems.attachment": true}'
            ]
        ]);

        for($count=0; $count < 10;$count++){
            DB::table('users')->insert([
                [
                    'id' => $faker->uuid(),
                    'name' => $faker->name(),
                    'email' => $faker->email(),
                    'password' => Hash::make('asdasd'),
                    'phone' => $faker->phoneNumber(),
                    'birthday' => Carbon::now(),
                ]
            ]);
        }

    }
}
