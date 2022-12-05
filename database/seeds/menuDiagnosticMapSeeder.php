<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class menuDiagnosticMapSeeder extends Seeder
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
        'title' => 'Suvi dianostiques map',
        'icon' => 'fa-map',
        'uri' => 'orientation-medicale-maps',
        'permission' => null,
        'created_at' => null,
        'updated_at' => null,
      ],
    ]);
  }
}
