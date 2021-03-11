<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewAdminRole extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('admin_roles')->insert([
      [
        "name" => "manager_epidemic",
        "slug" => 'manager_epidemic',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
      ],
    ]);
  }
}
