<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Factory;

class FoodIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('food_ingredients')->insert([
            [
                'food_id' => App\Food::all()->random()->id,
                'name' => "Telur",
            ],
            [
                'food_id' => App\Food::all()->random()->id,
                'name' => "Madu",
            ],
            [
                'food_id' => App\Food::all()->random()->id,
                'name' => "Cabai Rawit",
            ],
            [
                'food_id' => App\Food::all()->random()->id,
                'name' => "Ayam",
            ],
            [
                'food_id' => App\Food::all()->random()->id,
                'name' => "Sawi",
            ],
            [
                'food_id' => App\Food::all()->random()->id,
                'name' => "Lemon",
            ],
            [
                'food_id' => App\Food::all()->random()->id,
                'name' => "Alpukat",
            ],
            [
                'food_id' => App\Food::all()->random()->id,
                'name' => "Es",
            ],
        ]);
    }
}
