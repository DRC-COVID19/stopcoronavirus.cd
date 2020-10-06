<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Administrator;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Administrator::class, function (Faker $faker) {
  return [
      'name' => $faker->name,
      'email' => $faker->unique()->safeEmail,
      'username'=>$faker->unique()->userName,
      // 'email_verified_at' => now(),
      'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
      'remember_token' => Str::random(10),
  ];
});
