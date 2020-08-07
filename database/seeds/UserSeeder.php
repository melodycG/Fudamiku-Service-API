<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Factory;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        DB::table('users')->insert([
            'uuid' => $faker->uuid,
            'name' => "Abu Toyib Al Aziz",
            'email'=> "abuaziz0204@gmail.com",
            'email_verified_at' => $faker->dateTime,
            'password' => bcrypt("black14flame"),
            'phone_number' => "085718465342",
            'address' => "Jln. Bleter 3, Pekayon Jaya, Bekasi Selatan",
            'house_number' => 2,
            'city' => "Bekasi",
            'photo' => "/images/users/abu.png",
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
