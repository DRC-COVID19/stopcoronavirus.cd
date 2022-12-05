<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class role_admin_hospital extends Seeder
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
        'name' => 'admin-hospital',
        'slug' => 'admin-hospital',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
    ]);
  }
}
