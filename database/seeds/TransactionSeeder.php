<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Factory;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        DB::table('transactions')->insert([
            [
                'order_id' => 1,
                'user_id' => App\User::all()->random()->id,
                'uuid' => $faker->uuid,
                'delivery_service' => 7000,
                'tax' => 2000,
                'total_price' => $faker->numberBetween(10000, 90000),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'order_id' => 2,
                'user_id' => App\User::all()->random()->id,
                'uuid' => $faker->uuid,
                'delivery_service' => 7000,
                'tax' => 2000,
                'total_price' => $faker->numberBetween(10000, 90000),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'order_id' => 3,
                'user_id' => App\User::all()->random()->id,
                'uuid' => $faker->uuid,
                'delivery_service' => 7000,
                'tax' => 2000,
                'total_price' => $faker->numberBetween(10000, 90000),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'order_id' => 4,
                'user_id' => App\User::all()->random()->id,
                'uuid' => $faker->uuid,
                'delivery_service' => 7000,
                'tax' => 2000,
                'total_price' => $faker->numberBetween(10000, 90000),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
