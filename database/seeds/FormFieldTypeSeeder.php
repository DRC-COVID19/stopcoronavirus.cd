<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormFieldTypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('form_field_types')->truncate();
    DB::table('form_field_types')->insert([
      [
        'id' => 1,
        'name' => 'text',
      ],
      ['id' => 2, 'name' => 'number'],
      [
        'id' => 3,
        'name' => 'boolean',
      ],
      ['id' => 4, 'name' => 'date'],
    ]);
  }
}
