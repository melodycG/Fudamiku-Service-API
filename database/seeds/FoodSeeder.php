<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Factory;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        DB::table('foods')->insert([
            [
                'name' => "Tahu Gejrot Cirebon",
                'score' => 9.5,
                'description' =>  "Tahu gejrot merupakan salah satu makanan khas Cirebon yang cukup digemari. Makanan ini berwujud tahu goreng yang disiram dengan kuah atau saus yang nikmat. Nah saus dan kuah ini lah yang membuat makanan berbahan dasar tahu ini punya cita rasa yang menggugah selera.",
                'price' => 20000,
                'picture' => $faker->imageUrl,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => "Martabak Telor/Manis",
                'score' => 9.8,
                'description' =>  "Martabak merupakan salah satu makanan khas Cirebon yang cukup digemari. Makanan ini berwujud martabak goreng yang disiram dengan kuah atau saus yang nikmat. Nah saus dan kuah ini lah yang membuat makanan berbahan dasar martabak ini punya cita rasa yang menggugah selera.",
                'price' => 35000,
                'picture' => $faker->imageUrl,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => "Nasi Goreng Omelet",
                'score' => 8.5,
                'description' =>  "Nasi Goreng merupakan salah satu makanan khas Cirebon yang cukup digemari. Makanan ini berwujud martabak goreng yang disiram dengan kuah atau saus yang nikmat. Nah saus dan kuah ini lah yang membuat makanan berbahan dasar martabak ini punya cita rasa yang menggugah selera.",
                'price' => 15000,
                'picture' => $faker->imageUrl,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'name' => "Seblak Bandungz",
                'score' => 8.3,
                'description' =>  "Seblak Bandung merupakan salah satu makanan khas Cirebon yang cukup digemari. Makanan ini berwujud martabak goreng yang disiram dengan kuah atau saus yang nikmat. Nah saus dan kuah ini lah yang membuat makanan berbahan dasar martabak ini punya cita rasa yang menggugah selera.",
                'price' => 18000,
                'picture' => $faker->imageUrl,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ],
        ]);
    }
}
