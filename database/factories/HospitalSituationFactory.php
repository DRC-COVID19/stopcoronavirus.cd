<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Hospital;
use App\HospitalSituation;
use Faker\Generator as Faker;

$factory->define(HospitalSituation::class, function (Faker $faker) {
  return [
    // 'hospital_id'=>factory(Hospital::class)->create()->id,
    'confirmed' => $faker->numberBetween(),
    'sick' => $faker->numberBetween(),
    'healed' => $faker->numberBetween(),
    'dead' => $faker->numberBetween(),
    'last_update' => now(),
  ];
});
