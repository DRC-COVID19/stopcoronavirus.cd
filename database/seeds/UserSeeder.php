<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->truncate();
        DB::table('admin_users')->insert([
            [
                "username" => 'dash-admin',
                'password' => Hash::make('l8ab4yiaupo0ndwf'),
                "name" => 'admin',
                'email' => 'accounts@kinshasadigital.com'
            ],

        ]);
        
    }
}
