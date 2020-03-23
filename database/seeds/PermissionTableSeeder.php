<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_permissions')->insert(
            [
                [
                    'name' => 'operator_sms',
                    'slug' => 'operator_sms',
                    'http_method' => '',
                    'http_path' => ''
                ],
                [
                    'name' => 'validator_sms',
                    'slug' => 'validator_sms',
                    'http_method' => '',
                    'http_path' => ''
                ],
                [
                    'name' => 'telco',
                    'slug' => 'telco',
                    'http_method' => '',
                    'http_path' => ''
                ]
            ]
        );
    }
}
