<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalMenuSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('admin_menu')->insert([
      0 => [
        'parent_id' => 0,
        'order' => 2,
        'title' => 'Hopital',
        'icon' => 'fa-map',
        'uri' => 'hospitals',
        'permission' => null,
        'created_at' => null,
        'updated_at' => null,
      ],
      1 => [
        'parent_id' => 0,
        'order' => 2,
        'title' => 'Hopital-situations',
        'icon' => 'fa-map',
        'uri' => 'hospital-situations',
        'permission' => null,
        'created_at' => null,
        'updated_at' => null,
      ],
    ]);
  }
}
