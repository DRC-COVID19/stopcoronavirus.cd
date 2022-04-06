<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_roles')->truncate();
        DB::table('admin_roles')->insert([
            [
                'name' => 'Administrator',
                'slug' => 'administrator',
                'label' => 'Administrateur',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'telecom',
                'slug' => 'telecom',
                'label' => 'Telecom',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'sms',
                'slug' => 'sms',
                'label' => 'SMS',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'admin-dashboard',
                'slug' => 'admin-dashboard',
                'label' => 'Administrateur',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'agent-hospital',
                'slug' => 'agent-hospital',
                'label' => 'Agent Point Focal',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'admin-hospital',
                'slug' => 'admin-hospital',
                'label' => 'Administrateur',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'manager_epidemic',
                'slug' => 'manager_epidemic',
                'label' => 'Administrateur',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'  => 'create_form',
                'slug' => 'create_form',
                'label' => 'Administrateur',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'edit_form',
                'slug' => 'edit_form',
                'label' => 'Administrateur',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
