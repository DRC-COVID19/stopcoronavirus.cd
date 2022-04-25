<?php

use App\CompletedFormField;
use Illuminate\Database\Seeder;

class CompletedFormFieldSeeder extends Seeder
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
            for ($j = 1; $j <= 31; $j++) {
                CompletedFormField::insert([
                    'value' => $faker->numberBetween(1, 9),
                    'completed_form_id' => $i + 12,
                    'form_field_id' => $j,

                ]);
            }
        }
    }
}
