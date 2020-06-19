<?php

use Illuminate\Database\Seeder;

class HealthZoneHealthZonesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('health_zones')->delete();
        
        \DB::table('health_zones')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Gombe',
                'latitude' => '-4.3095347',
                'longitude' => '15.2926308',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 11:43:24',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Binza Ozone',
                'latitude' => '-4.348020429382444',
                'longitude' => '15.242345222290048',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 11:54:44',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Limete',
                'latitude' => '-4.350633999999999',
                'longitude' => '15.348246',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 11:55:17',
            ),
            3 => 
            array (
                'id' => 4,
            'name' => 'Kokolo (Ndolo)',
                'latitude' => '-4.3199632',
                'longitude' => '15.3292177',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 11:57:36',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Binza Méteo',
                'latitude' => '-4.36161',
                'longitude' => '15.2384967',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 11:58:01',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Lemba',
                'latitude' => '-4.396010699999999',
                'longitude' => '15.3189726',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 11:58:32',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Kalamu 1',
                'latitude' => '-4.3488157',
                'longitude' => '15.3160455',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 11:59:59',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Lingwala',
                'latitude' => '-4.319352999999999',
                'longitude' => '15.2984842',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:00:33',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Kintambo',
                'latitude' => '-4.343598',
                'longitude' => '15.26775619999999',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:00:58',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Matete',
                'latitude' => '-4.3878727',
                'longitude' => '15.3511736',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:01:24',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Kingabwa',
                'latitude' => '-4.331000400000001',
                'longitude' => '15.3439173',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:01:50',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Kasa-vubu',
                'latitude' => '-4.344086000000001',
                'longitude' => '15.3043378',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:02:18',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Kinshasa',
                'latitude' => '-4.323859884239902',
                'longitude' => '15.308840078466796',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:03:28',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Bandalungwa',
                'latitude' => '-4.3394767',
                'longitude' => '15.2867776',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:03:56',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Barumbu',
                'latitude' => '-4.318751100000001',
                'longitude' => '15.3277541',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:04:23',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'N\'sele',
                'latitude' => '-4.942558399999999',
                'longitude' => '15.6512395',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:07:58',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Selembao',
                'latitude' => '-4.3842422',
                'longitude' => '15.2867776',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:09:44',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Bumbu',
                'latitude' => '-4.374169300000001',
                'longitude' => '15.2926308',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:11:29',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Ngiri-Ngiri',
                'latitude' => '-4.359125100000001',
                'longitude' => '15.2984842',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:11:59',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Mont-Ngafula 1',
                'latitude' => '-4.4263717',
                'longitude' => '15.2955575',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:14:56',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Mont-Ngafula 2',
                'latitude' => '-4.353996366111101',
                'longitude' => '15.20167367339813',
                'created_at' => NULL,
                'updated_at' => '2020-06-19 12:45:21',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Kalamu 2',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Masina 1',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Kikimi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Maluku 1',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'N\'djili',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Makala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Ngaba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Masina 2',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Kisenso',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Kimbanseke',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Zone indeterminée',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Goma',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Beni',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Butembo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Ibanda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Nyankunde',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Bunia',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Idiofa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Kenya',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Tshamilemba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Kasumbalesa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Matadi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Nzanza',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}