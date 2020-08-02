<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Factory;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        DB::table('orders')->insert([
            [
                'user_id' => App\User::all()->random()->id,
                'food_id' => App\Food::all()->random()->id,
                'uuid' => $faker->uuid,
                'quantity' => $faker->randomDigit,
                'status' => 'Paid',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'user_id' => App\User::all()->random()->id,
                'food_id' => App\Food::all()->random()->id,
                'uuid' => $faker->uuid,
                'quantity' => $faker->randomDigit,
                'status' => 'Paid',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'user_id' => App\User::all()->random()->id,
                'food_id' => App\Food::all()->random()->id,
                'uuid' => $faker->uuid,
                'quantity' => $faker->randomDigit,
                'status' => 'Paid',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'user_id' => App\User::all()->random()->id,
                'food_id' => App\Food::all()->random()->id,
                'uuid' => $faker->uuid,
                'quantity' => $faker->randomDigit,
                'status' => 'Cancelled',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
