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
                'food_id' => 1,
                'name' => "Tahu",
            ],
            [
                'food_id' => 1,
                'name' => "Bawang",
            ],
            [
                'food_id' => 1,
                'name' => "Cabai Rawit",
            ],
            [
                'food_id' => 1,
                'name' => "Aren",
            ],
            [
                'food_id' => 2,
                'name' => "Tepung",
            ],
            [
                'food_id' => 2,
                'name' => "Mentega",
            ],
            [
                'food_id' => 2,
                'name' => "Krim",
            ],
            [
                'food_id' => 2,
                'name' => "Minyak",
            ],
            [
                'food_id' => 3,
                'name' => "Nasi",
            ],
            [
                'food_id' => 3,
                'name' => "Rempah",
            ],
            [
                'food_id' => 3,
                'name' => "Krim",
            ],
            [
                'food_id' => 3,
                'name' => "Minyak",
            ],
        ]);
    }
}
