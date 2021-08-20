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
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
                "name" => 'admin',
                'email' => 'accounts@kinshasadigital.com',
                'email_verified_at' => '2021-08-20 00:00:00',
                'password' => ' l8ab4yiaupo0ndwf'
            ],

        ]);
        
    }
}
