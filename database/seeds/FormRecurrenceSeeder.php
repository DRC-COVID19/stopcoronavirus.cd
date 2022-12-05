<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormRecurrenceSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('form_recurrences')->truncate();
    DB::table('form_recurrences')->insert([
      [
        'name' => 'jour',
        'slug' => 'day',
      ],
      [
        'name' => 'semaine',
        'slug' => 'week',
      ],
      [
        'name' => 'mois',
        'slug' => 'month',
      ],
      [
        'name' => 'année',
        'slug' => 'year',
      ],
    ]);
  }
}
