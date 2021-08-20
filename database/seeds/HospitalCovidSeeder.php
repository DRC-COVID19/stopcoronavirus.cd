<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HospitalCovidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('hospitals')->truncate();
        DB::table('hospitals')->insert([
            [
                "name" => 'NGALIEMA',
                'latitude' => '-4.31435',
                'longitude' => '15.27123',
                'address' => ''
            ],
            [
                "name" => 'DIAMANT',
                'latitude' => '-4.304099',
                'longitude' => '15.306571',
                'address' => ''
            ],
            [
                "name" => 'MONKOLE',
                'latitude' => '-4.322099199999999',
                'longitude' => '15.312486399999997', 'address' => ''
            ],
            [
                "name" => 'SAINT JOSEPH',
                'latitude' => '-4.36593',
                'longitude' => '15.3408', 'address' => ''
            ],
            [
                "name" => 'CUK',
                'latitude' => '-4.41405',
                'longitude' => '15.30541', 'address' => ''
            ],
            [
                "name" => 'VIJANA',
                'latitude' => '',
                'longitude' => '', 'address' => ''
            ],
            [
                "name" => 'ZONE DE SANTE STADE DE MARTYRS',
                'latitude' => '-4.3357',
                'longitude' => '15.31', 'address' => ''
            ],
            [
                "name" => 'ZONE DE SANTE GHK',
                'latitude' => '-4.3183',
                'longitude' => '15.2729', 'address' => ''
            ],
            [
                "name" => 'CINQUANTENAIRE',
                'latitude' => '-4.3467',
                'longitude' => '15.2959', 'address' => ''
            ],
            [
                "name" => 'KINKOLE',
                'latitude' => '',
                'longitude' => '', 'address' => ''
            ],
            [
                "name" => ' HASC',
                'latitude' => '-4.40364',
                'longitude' => '15.37435', 'address' => ''
            ],
            [
                "name" => ' CMK',
                'latitude' => '-4.299514',
                'longitude' => '15.316396', 'address' => ''
            ],
        ]);
    }
}
