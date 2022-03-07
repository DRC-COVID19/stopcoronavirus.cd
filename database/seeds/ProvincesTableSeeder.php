<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::table('provinces')->truncate();
        
        DB::table('provinces')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Bas-Uele',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '3.9901009',
                'longitude' => '24.9042208',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Equateur',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '3.9901009',
                'longitude' => '24.9042208',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Haut-Katanga',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-10.4102075',
                'longitude' => '27.5495846',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Haut-Lomami',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-7.705275199999998',
                'longitude' => '24.9042208',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Haut-Uele',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '3.5845154',
                'longitude' => '28.299435',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Ituri',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '1.85',
                'longitude' => '29.966667',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Kasaï',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-5.0471979',
                'longitude' => '20.7122465',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Kasaï-Central',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-6.2514921',
                'longitude' => '22.2384017',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Kasaï-Oriental',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-6.2514921',
                'longitude' => '22.2384017',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Kinshasa',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-4.4419311',
                'longitude' => '15.2662931',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Kongo-Central',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-5.2365685',
                'longitude' => '13.914399',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Kwango',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-6.4337409',
                'longitude' => '17.668887',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Kwilu',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-5.1188825',
                'longitude' => '18.4276047',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Lomami',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-1.899681',
                'longitude' => '22.72851',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Lualaba',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-10.48087',
                'longitude' => '25.634159',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Maï-Ndombe',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-2.6357434',
                'longitude' => '18.4276047',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Maniema',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-1.167485',
                'longitude' => '28.61903',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Mongala',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '1.9962324',
                'longitude' => '21.4752851',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Nord-Kivu',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-0.7917729',
                'longitude' => '29.0459927',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Nord-Ubangi',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '3.7878726',
                'longitude' => '21.4752851',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Sankuru',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-2.8437453',
                'longitude' => '23.38235449999999',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Sud-Kivu',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-3.011658',
                'longitude' => '28.299435',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Sud-Ubangi',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '3.2299942',
                'longitude' => '19.1880047',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Tanganyika',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-6.274011799999998',
                'longitude' => '27.9249002',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Tshopo',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-10.21105',
                'longitude' => '24.84374',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'Tshuapa',
                'created_at' => NULL,
                'updated_at' => NULL,
                'latitude' => '-0.9903022999999997',
                'longitude' => '23.0288844',
            ),
        ));
        
        
    }
}