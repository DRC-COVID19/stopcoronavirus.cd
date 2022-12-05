<?php

use App\CompletedForm;
use Illuminate\Database\Seeder;

class CompletedFormSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $faker = Faker\Factory::create();
    $rows = 1000;
    for ($i = 0; $i < $rows; $i++) {
      CompletedForm::insert([
        'form_id' => 1,
        'admin_user_id' => 1,
        'hospital_id' => 3,
        'created_manager_name' => $faker->name,
        'created_manager_first_name' => $faker->firstName,
        'last_update' => $faker
          ->unique()
          ->date($format = 'Y-m-d', $max = 'now'),
      ]);
    }
  }
}
