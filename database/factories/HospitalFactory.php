<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Hospital;
use Faker\Generator as Faker;

$factory->define(Hospital::class, function (Faker $faker) {
    $beds=$faker->numberBetween(10,100);
    $respirators=$faker->numberBetween(10,100);
    return [
        'name'=>$faker->company,
        'address'=>$faker->address,
        'beds'=>$beds,
        'occupied_beds'=>$faker->numberBetween(0,$beds),
        'respirators'=>$respirators,
        'occupied_respirators'=>$faker->numberBetween(0,$respirators),
        'masks'=>$faker->numberBetween(0,1000),
        'longitude'=>$faker->longitude,
        'latitude'=>$faker->latitude,
    ];
});
