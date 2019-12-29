<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Social;
use Faker\Generator as Faker;

$factory->define(Social::class, function (Faker $faker) {
    return [

//        'user_id' => $faker->randomElement($array = array (1, 2, 3)),
        'email' => $faker->email,
        'name' => $faker->name,
        'nick_name' => $faker->lastName,
        'provider_user_id' => $faker->randomNumber($nbDigits = NULL, $strict = false),
        'provider' => $faker->randomElement($array = array (
            'google','facebook','twiter'
        )),
        'avatar' => $faker->url,
    ];
});
