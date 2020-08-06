<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HealthZonesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        DB::table('health_zones')->truncate();
        DB::table('health_zones')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Gombe',
                'latitude' => '-4.3095347',
                'longitude' => '15.2926308',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 10,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Binza Ozone',
                'latitude' => '-4.348020429382444',
                'longitude' => '15.242345222290048',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Limete',
                'latitude' => '-4.350633999999999',
                'longitude' => '15.348246',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Kokolo',
                'latitude' => '-4.3199632',
                'longitude' => '15.3292177',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Binza Méteo',
                'latitude' => '-4.36161',
                'longitude' => '15.2384967',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Lemba',
                'latitude' => '-4.396010699999999',
                'longitude' => '15.3189726',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Kalamu I',
                'latitude' => '-4.3488157',
                'longitude' => '15.3160455',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:50:21',
                'province_id' => 10,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Lingwala',
                'latitude' => '-4.319352999999999',
                'longitude' => '15.2984842',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Kintambo',
                'latitude' => '-4.343598',
                'longitude' => '15.26775619999999',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Matete',
                'latitude' => '-4.3878727',
                'longitude' => '15.3511736',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Kingabwa',
                'latitude' => '-4.331000400000001',
                'longitude' => '15.3439173',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 10,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Kasa-vubu',
                'latitude' => '-4.344086000000001',
                'longitude' => '15.3043378',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Kinshasa',
                'latitude' => '-4.323859884239902',
                'longitude' => '15.308840078466796',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Bandalungwa',
                'latitude' => '-4.3394767',
                'longitude' => '15.2867776',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Barumbu',
                'latitude' => '-4.318751100000001',
                'longitude' => '15.3277541',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'N\'sele',
                'latitude' => '-4.942558399999999',
                'longitude' => '15.6512395',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:52:44',
                'province_id' => 10,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Selembao',
                'latitude' => '-4.3842422',
                'longitude' => '15.2867776',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Bumbu',
                'latitude' => '-4.374169300000001',
                'longitude' => '15.2926308',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'Ngiri-Ngiri',
                'latitude' => '-4.359125100000001',
                'longitude' => '15.2984842',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'Mont-Ngafula I',
                'latitude' => '-4.4263717',
                'longitude' => '15.2955575',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:50:21',
                'province_id' => 10,
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Mont-Ngafula II',
                'latitude' => '-4.353996366111101',
                'longitude' => '15.20167367339813',
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:50:21',
                'province_id' => 10,
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Kalamu II',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:50:21',
                'province_id' => 10,
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Masina I',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:50:21',
                'province_id' => 10,
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Kikimi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'Maluku I',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:50:22',
                'province_id' => 10,
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'N\'djili',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:52:44',
                'province_id' => 10,
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Makala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Ngaba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Masina II',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:50:23',
                'province_id' => 10,
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Kisenso',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'Kimbanseke',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'Zone indeterminée',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Goma',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Beni',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Butembo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Ibanda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'Nyakunde',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 10:31:32',
                'province_id' => 6,
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'Bunia',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Idiofa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 13,
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Kenya',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Tshamilemba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Kasumbalesa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 3,
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'Matadi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 11,
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'Nzanza',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 11,
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Bukavu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 22,
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Police',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Kingasani',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Kadutu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'Mvuzi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 3,
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'Biyela',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Karisimbi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Himbi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 19,
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Lubumbashi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Boma',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'Lukula',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'Mbanza Ngungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 11,
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'Nyiragongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 10:31:32',
                'province_id' => 19,
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'Rutshuru',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            58 => 
            array (
                'id' => 60,
                'name' => 'Kasindi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 19,
            ),
            59 => 
            array (
                'id' => 61,
                'name' => 'Bonga Yasa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 13,
            ),
            60 => 
            array (
                'id' => 62,
                'name' => 'Kampemba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 3,
            ),
            61 => 
            array (
                'id' => 63,
                'name' => 'Katuba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            62 => 
            array (
                'id' => 64,
                'name' => 'Rwashi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            63 => 
            array (
                'id' => 65,
                'name' => 'Kenge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 12,
            ),
            64 => 
            array (
                'id' => 66,
                'name' => 'Kabare',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            65 => 
            array (
                'id' => 67,
                'name' => 'Malemba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 4,
            ),
            66 => 
            array (
                'id' => 68,
                'name' => 'Makiso',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 1,
            ),
            67 => 
            array (
                'id' => 69,
                'name' => 'Kimpese',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 11,
            ),
            68 => 
            array (
                'id' => 70,
                'name' => 'Muanda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 11,
            ),
            69 => 
            array (
                'id' => 71,
                'name' => 'Sekebanza',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 11,
            ),
            70 => 
            array (
                'id' => 72,
                'name' => 'Mutuanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 19,
            ),
            71 => 
            array (
                'id' => 73,
                'name' => 'Nyatende',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 22,
            ),
            72 => 
            array (
                'id' => 74,
                'name' => 'Panzi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 12,
            ),
            73 => 
            array (
                'id' => 75,
                'name' => 'Bagira',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            74 => 
            array (
                'id' => 76,
                'name' => 'Wangata',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            75 => 
            array (
                'id' => 77,
                'name' => 'Sonabata',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 11,
            ),
            76 => 
            array (
                'id' => 79,
                'name' => 'Lukala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 11,
            ),
            77 => 
            array (
                'id' => 80,
                'name' => 'Masa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 11,
            ),
            78 => 
            array (
                'id' => 81,
                'name' => 'Kapemba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 3,
            ),
            79 => 
            array (
                'id' => 82,
                'name' => 'Nyantende',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            80 => 
            array (
                'id' => 83,
                'name' => 'Mumbunda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            81 => 
            array (
                'id' => 84,
                'name' => 'Kisanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            82 => 
            array (
                'id' => 86,
                'name' => 'Kisantu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            83 => 
            array (
                'id' => 87,
                'name' => 'Kangu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 11,
            ),
            84 => 
            array (
                'id' => 88,
                'name' => 'Kwilu Ngongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 11,
            ),
            85 => 
            array (
                'id' => 89,
                'name' => 'Madula',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => NULL,
            ),
            86 => 
            array (
                'id' => 91,
                'name' => 'Bandundu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 13,
            ),
            87 => 
            array (
                'id' => 92,
                'name' => 'Kampemba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            88 => 
            array (
                'id' => 93,
                'name' => 'Kamalondo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            89 => 
            array (
                'id' => 94,
                'name' => 'Kipushi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 3,
            ),
            90 => 
            array (
                'id' => 95,
                'name' => 'Mambunda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 3,
            ),
            91 => 
            array (
                'id' => 96,
                'name' => 'Watsa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            92 => 
            array (
                'id' => 97,
                'name' => 'Likasi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            93 => 
            array (
                'id' => 98,
                'name' => 'Panda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            94 => 
            array (
                'id' => 99,
                'name' => 'Boko Kivula',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 11,
            ),
            95 => 
            array (
                'id' => 100,
                'name' => 'Buta',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 1,
            ),
            96 => 
            array (
                'id' => 101,
                'name' => 'Kadutu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 22,
            ),
            97 => 
            array (
                'id' => 102,
                'name' => 'Miti Murhesa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
                'province_id' => 22,
            ),
            98 => 
            array (
                'id' => 103,
                'name' => 'Fungurume',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            99 => 
            array (
                'id' => 104,
                'name' => 'Luozi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            100 => 
            array (
                'id' => 105,
                'name' => 'Lualaba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            101 => 
            array (
                'id' => 106,
                'name' => 'Uvira',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            102 => 
            array (
                'id' => 107,
                'name' => 'Gemena',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 23,
            ),
            103 => 
            array (
                'id' => 108,
                'name' => 'Sakania',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            104 => 
            array (
                'id' => 109,
                'name' => 'Walikale',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            105 => 
            array (
                'id' => 110,
                'name' => 'Kabondo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            106 => 
            array (
                'id' => 111,
                'name' => 'Fizi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            107 => 
            array (
                'id' => 112,
                'name' => 'Wembo Nyama',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            108 => 
            array (
                'id' => 113,
                'name' => 'Kole',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            109 => 
            array (
                'id' => 114,
                'name' => 'Pania Mutombo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            110 => 
            array (
                'id' => 115,
                'name' => 'Minga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            111 => 
            array (
                'id' => 116,
                'name' => 'Lusambo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            112 => 
            array (
                'id' => 117,
                'name' => 'Dikungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            113 => 
            array (
                'id' => 118,
                'name' => 'Vanga Kete',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            114 => 
            array (
                'id' => 119,
                'name' => 'Lodja',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            115 => 
            array (
                'id' => 120,
                'name' => 'Omendjadi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            116 => 
            array (
                'id' => 121,
                'name' => 'Djalo Djeka',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            117 => 
            array (
                'id' => 122,
                'name' => 'Katako Kombe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            118 => 
            array (
                'id' => 123,
                'name' => 'Bena Dibele',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 21,
            ),
            119 => 
            array (
                'id' => 124,
                'name' => 'Kamiji',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            120 => 
            array (
                'id' => 125,
                'name' => 'Tshitenge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            121 => 
            array (
                'id' => 126,
                'name' => 'Miabi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            122 => 
            array (
                'id' => 127,
                'name' => 'Ngandajika',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            123 => 
            array (
                'id' => 128,
                'name' => 'Mulumba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            124 => 
            array (
                'id' => 129,
                'name' => 'Tshilenge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            125 => 
            array (
                'id' => 130,
                'name' => 'Cilundu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            126 => 
            array (
                'id' => 131,
                'name' => 'Lubao',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            127 => 
            array (
                'id' => 132,
                'name' => 'Kalonda Est',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            128 => 
            array (
                'id' => 133,
                'name' => 'Kabinda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            129 => 
            array (
                'id' => 134,
                'name' => 'Ludimbi Lukula',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            130 => 
            array (
                'id' => 135,
                'name' => 'Kalambayi Kabanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            131 => 
            array (
                'id' => 136,
                'name' => 'Makota',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            132 => 
            array (
                'id' => 137,
                'name' => 'Mwene Ditu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            133 => 
            array (
                'id' => 138,
                'name' => 'Wikong',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            134 => 
            array (
                'id' => 139,
                'name' => 'Luputa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            135 => 
            array (
                'id' => 140,
                'name' => 'Kanda Kanda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            136 => 
            array (
                'id' => 141,
                'name' => 'Bonzola',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            137 => 
            array (
                'id' => 142,
                'name' => 'Dibindi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            138 => 
            array (
                'id' => 143,
                'name' => 'Kansele',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            139 => 
            array (
                'id' => 144,
                'name' => 'Muya',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            140 => 
            array (
                'id' => 145,
                'name' => 'Diulu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            141 => 
            array (
                'id' => 146,
                'name' => 'Bipemba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            142 => 
            array (
                'id' => 147,
                'name' => 'Mpokolo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            143 => 
            array (
                'id' => 148,
                'name' => 'Nzaba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            144 => 
            array (
                'id' => 149,
                'name' => 'Kabeya Kamuanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            145 => 
            array (
                'id' => 150,
                'name' => 'Mukumbi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            146 => 
            array (
                'id' => 151,
                'name' => 'Lukelenge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            147 => 
            array (
                'id' => 152,
                'name' => 'Tshishimbi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            148 => 
            array (
                'id' => 153,
                'name' => 'Lubilanji',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            149 => 
            array (
                'id' => 154,
                'name' => 'Kamana',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            150 => 
            array (
                'id' => 155,
                'name' => 'Kasansa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            151 => 
            array (
                'id' => 156,
                'name' => 'Bibanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 9,
            ),
            152 => 
            array (
                'id' => 157,
                'name' => 'Kalenda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            153 => 
            array (
                'id' => 158,
                'name' => 'Tshofa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 14,
            ),
            154 => 
            array (
                'id' => 159,
                'name' => 'Pimu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 18,
            ),
            155 => 
            array (
                'id' => 160,
                'name' => 'Nyanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 7,
            ),
            156 => 
            array (
                'id' => 161,
                'name' => 'Kalonda Ouest',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 7,
            ),
            157 => 
            array (
                'id' => 162,
                'name' => 'Kamonia',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 7,
            ),
            158 => 
            array (
                'id' => 163,
                'name' => 'Mutena',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 7,
            ),
            159 => 
            array (
                'id' => 164,
                'name' => 'Banga Lubaka',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 7,
            ),
            160 => 
            array (
                'id' => 165,
                'name' => 'Kamwesha',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 7,
            ),
            161 => 
            array (
                'id' => 166,
                'name' => 'Mweka',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 7,
            ),
            162 => 
            array (
                'id' => 167,
                'name' => 'Moba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 24,
            ),
            163 => 
            array (
                'id' => 168,
                'name' => 'Bogosenubia',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 23,
            ),
            164 => 
            array (
                'id' => 169,
                'name' => 'Moanda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            165 => 
            array (
                'id' => 170,
                'name' => 'Kitona',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            166 => 
            array (
                'id' => 171,
                'name' => 'Boma Bungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            167 => 
            array (
                'id' => 172,
                'name' => 'Seke-Banza',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            168 => 
            array (
                'id' => 173,
                'name' => 'Inga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            169 => 
            array (
                'id' => 174,
                'name' => 'Tshela',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            170 => 
            array (
                'id' => 175,
                'name' => 'Vaku',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            171 => 
            array (
                'id' => 176,
                'name' => 'Kizu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            172 => 
            array (
                'id' => 177,
                'name' => 'Kibunzi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            173 => 
            array (
                'id' => 178,
                'name' => 'Kimpangu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            174 => 
            array (
                'id' => 179,
                'name' => 'Ngidinga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            175 => 
            array (
                'id' => 180,
                'name' => 'Boko-Kivulu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            176 => 
            array (
                'id' => 181,
                'name' => 'Mbanza-Ngungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            177 => 
            array (
                'id' => 182,
                'name' => 'Kwilu-Ngongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 11,
            ),
            178 => 
            array (
                'id' => 183,
                'name' => 'Mikope',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 7,
            ),
            179 => 
            array (
                'id' => 184,
                'name' => 'Oshwe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 16,
            ),
            180 => 
            array (
                'id' => 185,
                'name' => 'Bosobe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 16,
            ),
            181 => 
            array (
                'id' => 186,
                'name' => 'Bokoro',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 16,
            ),
            182 => 
            array (
                'id' => 187,
                'name' => 'Masi-Manimba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 13,
            ),
            183 => 
            array (
                'id' => 188,
                'name' => 'Yasa-Bonga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 13,
            ),
            184 => 
            array (
                'id' => 189,
                'name' => 'Ipamu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 13,
            ),
            185 => 
            array (
                'id' => 190,
                'name' => 'Koshibanda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 13,
            ),
            186 => 
            array (
                'id' => 191,
                'name' => 'Kingandu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 13,
            ),
            187 => 
            array (
                'id' => 192,
                'name' => 'Bulungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 13,
            ),
            188 => 
            array (
                'id' => 193,
                'name' => 'Bagata',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 13,
            ),
            189 => 
            array (
                'id' => 194,
                'name' => 'Kajiji',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 12,
            ),
            190 => 
            array (
                'id' => 195,
                'name' => 'Kikwit-Nord',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 13,
            ),
            191 => 
            array (
                'id' => 196,
                'name' => 'Lusanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 13,
            ),
            192 => 
            array (
                'id' => 197,
                'name' => 'Feshi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 12,
            ),
            193 => 
            array (
                'id' => 198,
                'name' => 'Wamba Lwadi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 12,
            ),
            194 => 
            array (
                'id' => 199,
                'name' => 'Tembo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:07',
                'updated_at' => '2020-08-06 09:45:07',
                'province_id' => 12,
            ),
            195 => 
            array (
                'id' => 200,
                'name' => 'Moanza',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 13,
            ),
            196 => 
            array (
                'id' => 201,
                'name' => 'Kimbau',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 12,
            ),
            197 => 
            array (
                'id' => 202,
                'name' => 'Boko',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 12,
            ),
            198 => 
            array (
                'id' => 203,
                'name' => 'Viadana',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 1,
            ),
            199 => 
            array (
                'id' => 204,
                'name' => 'Poko',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 1,
            ),
            200 => 
            array (
                'id' => 205,
                'name' => 'Basali',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            201 => 
            array (
                'id' => 206,
                'name' => 'Basoko',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            202 => 
            array (
                'id' => 207,
                'name' => 'Bengamisa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            203 => 
            array (
                'id' => 208,
                'name' => 'Yakusu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            204 => 
            array (
                'id' => 209,
                'name' => 'Yahisuli',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            205 => 
            array (
                'id' => 210,
                'name' => 'Yabaondo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            206 => 
            array (
                'id' => 211,
                'name' => 'Isangi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            207 => 
            array (
                'id' => 212,
                'name' => 'Yaleko',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            208 => 
            array (
                'id' => 213,
                'name' => 'Banalia',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            209 => 
            array (
                'id' => 214,
                'name' => 'Bafwasende',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            210 => 
            array (
                'id' => 215,
                'name' => 'Bafwagbogbo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            211 => 
            array (
                'id' => 216,
                'name' => 'Titule',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 1,
            ),
            212 => 
            array (
                'id' => 217,
                'name' => 'Ganga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 1,
            ),
            213 => 
            array (
                'id' => 218,
                'name' => 'Vanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 13,
            ),
            214 => 
            array (
                'id' => 219,
                'name' => 'Djuma',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 13,
            ),
            215 => 
            array (
                'id' => 220,
                'name' => 'Sia',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 13,
            ),
            216 => 
            array (
                'id' => 221,
                'name' => 'Mungindu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 13,
            ),
            217 => 
            array (
                'id' => 222,
                'name' => 'Kimputu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 13,
            ),
            218 => 
            array (
                'id' => 223,
                'name' => 'Mosango',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 13,
            ),
            219 => 
            array (
                'id' => 224,
                'name' => 'Pay Kongila',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 13,
            ),
            220 => 
            array (
                'id' => 225,
                'name' => 'Ndjili',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            221 => 
            array (
                'id' => 226,
                'name' => 'Mont-Ngafula I',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            222 => 
            array (
                'id' => 227,
                'name' => 'Kalamu II',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            223 => 
            array (
                'id' => 228,
                'name' => 'Kalamu I',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            224 => 
            array (
                'id' => 229,
                'name' => 'Masina I',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            225 => 
            array (
                'id' => 230,
                'name' => 'Kikongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 13,
            ),
            226 => 
            array (
                'id' => 231,
                'name' => 'Mont-Ngafula II',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            227 => 
            array (
                'id' => 232,
                'name' => 'Sona-Bata',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 11,
            ),
            228 => 
            array (
                'id' => 233,
                'name' => 'Nsele',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            229 => 
            array (
                'id' => 234,
                'name' => 'Kanzala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 7,
            ),
            230 => 
            array (
                'id' => 235,
                'name' => 'Tshikapa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 7,
            ),
            231 => 
            array (
                'id' => 236,
                'name' => 'Bwamanda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 23,
            ),
            232 => 
            array (
                'id' => 237,
                'name' => 'Kungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 23,
            ),
            233 => 
            array (
                'id' => 238,
                'name' => 'Loko',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 20,
            ),
            234 => 
            array (
                'id' => 239,
                'name' => 'Bangabola',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 23,
            ),
            235 => 
            array (
                'id' => 240,
                'name' => 'Boso Mondanda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 18,
            ),
            236 => 
            array (
                'id' => 241,
                'name' => 'Budjala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 23,
            ),
            237 => 
            array (
                'id' => 242,
                'name' => 'Binga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 18,
            ),
            238 => 
            array (
                'id' => 243,
                'name' => 'Yamaluka',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 18,
            ),
            239 => 
            array (
                'id' => 244,
                'name' => 'Boso Manzi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 18,
            ),
            240 => 
            array (
                'id' => 245,
                'name' => 'Karawa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 20,
            ),
            241 => 
            array (
                'id' => 246,
                'name' => 'Bominenge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 23,
            ),
            242 => 
            array (
                'id' => 247,
                'name' => 'Mbaya',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 23,
            ),
            243 => 
            array (
                'id' => 248,
                'name' => 'Bulu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 23,
            ),
            244 => 
            array (
                'id' => 249,
                'name' => 'Tandala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 23,
            ),
            245 => 
            array (
                'id' => 250,
                'name' => 'Kibombo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            246 => 
            array (
                'id' => 251,
                'name' => 'Kindu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            247 => 
            array (
                'id' => 252,
                'name' => 'Alunguli',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            248 => 
            array (
                'id' => 253,
                'name' => 'Makiso-Kisangani',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            249 => 
            array (
                'id' => 254,
                'name' => 'Mangobo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            250 => 
            array (
                'id' => 255,
                'name' => 'Tshopo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            251 => 
            array (
                'id' => 256,
                'name' => 'Kaniama',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 4,
            ),
            252 => 
            array (
                'id' => 257,
                'name' => 'Kalemie',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 24,
            ),
            253 => 
            array (
                'id' => 258,
                'name' => 'Kansimba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 24,
            ),
            254 => 
            array (
                'id' => 259,
                'name' => 'Butumba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 4,
            ),
            255 => 
            array (
                'id' => 260,
                'name' => 'Kinkondja',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 4,
            ),
            256 => 
            array (
                'id' => 261,
                'name' => 'Baka',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 4,
            ),
            257 => 
            array (
                'id' => 262,
                'name' => 'Kiyambi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 24,
            ),
            258 => 
            array (
                'id' => 263,
                'name' => 'Manono',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 24,
            ),
            259 => 
            array (
                'id' => 264,
                'name' => 'Samba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            260 => 
            array (
                'id' => 265,
                'name' => 'Kasongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            261 => 
            array (
                'id' => 266,
                'name' => 'Kunda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            262 => 
            array (
                'id' => 267,
                'name' => 'Saramabila',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            263 => 
            array (
                'id' => 268,
                'name' => 'Kampene',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            264 => 
            array (
                'id' => 269,
                'name' => 'Nyemba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 24,
            ),
            265 => 
            array (
                'id' => 270,
                'name' => 'Nyunzu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 24,
            ),
            266 => 
            array (
                'id' => 271,
                'name' => 'Kabambare',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            267 => 
            array (
                'id' => 272,
                'name' => 'Pangi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            268 => 
            array (
                'id' => 273,
                'name' => 'Kalima',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            269 => 
            array (
                'id' => 274,
                'name' => 'Yalimbongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            270 => 
            array (
                'id' => 275,
                'name' => 'Aketi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 1,
            ),
            271 => 
            array (
                'id' => 276,
                'name' => 'Lolo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 18,
            ),
            272 => 
            array (
                'id' => 277,
                'name' => 'Yamongili',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 18,
            ),
            273 => 
            array (
                'id' => 278,
                'name' => 'Abuzi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 20,
            ),
            274 => 
            array (
                'id' => 279,
                'name' => 'Yambuku',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 18,
            ),
            275 => 
            array (
                'id' => 280,
                'name' => 'Wasolo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 20,
            ),
            276 => 
            array (
                'id' => 281,
                'name' => 'Bosondjo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 18,
            ),
            277 => 
            array (
                'id' => 282,
                'name' => 'Bumba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 18,
            ),
            278 => 
            array (
                'id' => 283,
                'name' => 'Mondombe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 26,
            ),
            279 => 
            array (
                'id' => 284,
                'name' => 'Djolu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 26,
            ),
            280 => 
            array (
                'id' => 285,
                'name' => 'Opienge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            281 => 
            array (
                'id' => 286,
                'name' => 'Obokote',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            282 => 
            array (
                'id' => 287,
                'name' => 'Lowa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            283 => 
            array (
                'id' => 288,
                'name' => 'Wanierukula',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 25,
            ),
            284 => 
            array (
                'id' => 289,
                'name' => 'Lubutu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 17,
            ),
            285 => 
            array (
                'id' => 290,
                'name' => 'Kitenda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 12,
            ),
            286 => 
            array (
                'id' => 291,
                'name' => 'Kasongo Lunda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 12,
            ),
            287 => 
            array (
                'id' => 292,
                'name' => 'Popokabaka',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 12,
            ),
            288 => 
            array (
                'id' => 293,
                'name' => 'Kimvula',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 11,
            ),
            289 => 
            array (
                'id' => 294,
                'name' => 'Maluku I',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 10,
            ),
            290 => 
            array (
                'id' => 295,
                'name' => 'Nsona-Mpangu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 11,
            ),
            291 => 
            array (
                'id' => 296,
                'name' => 'Kuimba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 11,
            ),
            292 => 
            array (
                'id' => 297,
                'name' => 'Kinkonzi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:08',
                'updated_at' => '2020-08-06 09:45:08',
                'province_id' => 11,
            ),
            293 => 
            array (
                'id' => 298,
                'name' => 'Mangembo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 11,
            ),
            294 => 
            array (
                'id' => 299,
                'name' => 'Gombe-Matadi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 11,
            ),
            295 => 
            array (
                'id' => 300,
                'name' => 'Bokonzi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 23,
            ),
            296 => 
            array (
                'id' => 301,
                'name' => 'Mawuya',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 23,
            ),
            297 => 
            array (
                'id' => 302,
                'name' => 'Zongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 23,
            ),
            298 => 
            array (
                'id' => 303,
                'name' => 'Libenge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 23,
            ),
            299 => 
            array (
                'id' => 304,
                'name' => 'Bili',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 10:31:32',
                'province_id' => 1,
            ),
            300 => 
            array (
                'id' => 305,
                'name' => 'Gbadolite',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 20,
            ),
            301 => 
            array (
                'id' => 306,
                'name' => 'Mobayi Mbongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 20,
            ),
            302 => 
            array (
                'id' => 307,
                'name' => 'Yakoma',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 20,
            ),
            303 => 
            array (
                'id' => 308,
                'name' => 'Monga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 1,
            ),
            304 => 
            array (
                'id' => 309,
                'name' => 'Bondo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 1,
            ),
            305 => 
            array (
                'id' => 310,
                'name' => 'Ango',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 1,
            ),
            306 => 
            array (
                'id' => 311,
                'name' => 'Opala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 25,
            ),
            307 => 
            array (
                'id' => 312,
                'name' => 'Kahemba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 12,
            ),
            308 => 
            array (
                'id' => 313,
                'name' => 'Gungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 13,
            ),
            309 => 
            array (
                'id' => 314,
                'name' => 'Kitangwa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 7,
            ),
            310 => 
            array (
                'id' => 315,
                'name' => 'Mukedi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 13,
            ),
            311 => 
            array (
                'id' => 316,
                'name' => 'Kongolo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 24,
            ),
            312 => 
            array (
                'id' => 317,
                'name' => 'Mbulula',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 24,
            ),
            313 => 
            array (
                'id' => 318,
                'name' => 'Kabalo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 24,
            ),
            314 => 
            array (
                'id' => 319,
                'name' => 'Bukama',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            315 => 
            array (
                'id' => 320,
                'name' => 'Kabondo Dianda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            316 => 
            array (
                'id' => 321,
                'name' => 'Kabongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            317 => 
            array (
                'id' => 322,
                'name' => 'Songa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            318 => 
            array (
                'id' => 323,
                'name' => 'Kayamba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            319 => 
            array (
                'id' => 324,
                'name' => 'Kitenge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            320 => 
            array (
                'id' => 325,
                'name' => 'Ankoro',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 24,
            ),
            321 => 
            array (
                'id' => 326,
                'name' => 'Mulongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            322 => 
            array (
                'id' => 327,
                'name' => 'Lwamba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            323 => 
            array (
                'id' => 328,
                'name' => 'Mukanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            324 => 
            array (
                'id' => 329,
                'name' => 'Malemba Nkulu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            325 => 
            array (
                'id' => 330,
                'name' => 'Kinda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            326 => 
            array (
                'id' => 331,
                'name' => 'Kamina',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 4,
            ),
            327 => 
            array (
                'id' => 332,
                'name' => 'Kikwit-Sud',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 13,
            ),
            328 => 
            array (
                'id' => 333,
                'name' => 'Pweto',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            329 => 
            array (
                'id' => 334,
                'name' => 'Lukafu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            330 => 
            array (
                'id' => 335,
                'name' => 'Mufunga Sampwe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            331 => 
            array (
                'id' => 336,
                'name' => 'Kilwa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            332 => 
            array (
                'id' => 337,
                'name' => 'Kapolowe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            333 => 
            array (
                'id' => 338,
                'name' => 'Kashobwe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 3,
            ),
            334 => 
            array (
                'id' => 339,
                'name' => 'Bena Tshiadi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            335 => 
            array (
                'id' => 340,
                'name' => 'Yangala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            336 => 
            array (
                'id' => 341,
                'name' => 'Ilebo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 7,
            ),
            337 => 
            array (
                'id' => 342,
                'name' => 'Luebo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 7,
            ),
            338 => 
            array (
                'id' => 343,
                'name' => 'Bena Leka',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            339 => 
            array (
                'id' => 344,
                'name' => 'Muetshi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            340 => 
            array (
                'id' => 345,
                'name' => 'Tshikula',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            341 => 
            array (
                'id' => 346,
                'name' => 'Dibaya',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            342 => 
            array (
                'id' => 347,
                'name' => 'Kalomba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            343 => 
            array (
                'id' => 348,
                'name' => 'Tshibala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            344 => 
            array (
                'id' => 349,
                'name' => 'Mushenge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 7,
            ),
            345 => 
            array (
                'id' => 350,
                'name' => 'Bulape',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 7,
            ),
            346 => 
            array (
                'id' => 351,
                'name' => 'Masuika',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            347 => 
            array (
                'id' => 352,
                'name' => 'Luiza',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            348 => 
            array (
                'id' => 353,
                'name' => 'Katoka',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            349 => 
            array (
                'id' => 354,
                'name' => 'Ndesha',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            350 => 
            array (
                'id' => 355,
                'name' => 'Tshikaji',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            351 => 
            array (
                'id' => 356,
                'name' => 'Bilomba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            352 => 
            array (
                'id' => 357,
                'name' => 'Ndekesha',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            353 => 
            array (
                'id' => 358,
                'name' => 'Bunkonde',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            354 => 
            array (
                'id' => 359,
                'name' => 'Mikalayi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            355 => 
            array (
                'id' => 360,
                'name' => 'Luambo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            356 => 
            array (
                'id' => 361,
                'name' => 'Katende',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            357 => 
            array (
                'id' => 362,
                'name' => 'Ndjoko-Mpunda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 7,
            ),
            358 => 
            array (
                'id' => 363,
                'name' => 'Lubondaie',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            359 => 
            array (
                'id' => 364,
                'name' => 'Kakenge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 7,
            ),
            360 => 
            array (
                'id' => 365,
                'name' => 'Rwampara',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            361 => 
            array (
                'id' => 366,
                'name' => 'Jiba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            362 => 
            array (
                'id' => 367,
                'name' => 'Linga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            363 => 
            array (
                'id' => 368,
                'name' => 'Mangala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            364 => 
            array (
                'id' => 369,
                'name' => 'Damas',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            365 => 
            array (
                'id' => 370,
                'name' => 'Fataki',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            366 => 
            array (
                'id' => 371,
                'name' => 'Drodro',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            367 => 
            array (
                'id' => 372,
                'name' => 'Tchomia',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            368 => 
            array (
                'id' => 373,
                'name' => 'Rethy',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            369 => 
            array (
                'id' => 374,
                'name' => 'Nyakunde',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            370 => 
            array (
                'id' => 375,
                'name' => 'Nizi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            371 => 
            array (
                'id' => 376,
                'name' => 'Bambu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            372 => 
            array (
                'id' => 377,
                'name' => 'Kilo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            373 => 
            array (
                'id' => 378,
                'name' => 'Mongbalu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            374 => 
            array (
                'id' => 379,
                'name' => 'Komanda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            375 => 
            array (
                'id' => 380,
                'name' => 'Gethy',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            376 => 
            array (
                'id' => 381,
                'name' => 'Boga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            377 => 
            array (
                'id' => 382,
                'name' => 'Nia-Nia',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            378 => 
            array (
                'id' => 383,
                'name' => 'Mandima',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            379 => 
            array (
                'id' => 384,
                'name' => 'Lolwa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            380 => 
            array (
                'id' => 385,
                'name' => 'Lita',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            381 => 
            array (
                'id' => 386,
                'name' => 'Boma-Mangbetu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            382 => 
            array (
                'id' => 387,
                'name' => 'Isiro',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            383 => 
            array (
                'id' => 388,
                'name' => 'Wamba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            384 => 
            array (
                'id' => 389,
                'name' => 'Doruma',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            385 => 
            array (
                'id' => 390,
                'name' => 'Pawa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            386 => 
            array (
                'id' => 391,
                'name' => 'Niangara',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            387 => 
            array (
                'id' => 392,
                'name' => 'Rungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            388 => 
            array (
                'id' => 393,
                'name' => 'Mambasa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            389 => 
            array (
                'id' => 394,
                'name' => 'Rimba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            390 => 
            array (
                'id' => 395,
                'name' => 'Logo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            391 => 
            array (
                'id' => 396,
                'name' => 'Angumu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            392 => 
            array (
                'id' => 397,
                'name' => 'Nyarambe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            393 => 
            array (
                'id' => 398,
                'name' => 'Mahagi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            394 => 
            array (
                'id' => 399,
                'name' => 'Makoro',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            395 => 
            array (
                'id' => 400,
                'name' => 'Kambala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            396 => 
            array (
                'id' => 401,
                'name' => 'Biringi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            397 => 
            array (
                'id' => 402,
                'name' => 'Laybo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            398 => 
            array (
                'id' => 403,
                'name' => 'Ariwara',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            399 => 
            array (
                'id' => 404,
                'name' => 'Adi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            400 => 
            array (
                'id' => 405,
                'name' => 'Aru',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            401 => 
            array (
                'id' => 406,
                'name' => 'Adja',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            402 => 
            array (
                'id' => 407,
                'name' => 'Aungba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 6,
            ),
            403 => 
            array (
                'id' => 408,
                'name' => 'Faradje',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            404 => 
            array (
                'id' => 409,
                'name' => 'Gombari',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            405 => 
            array (
                'id' => 410,
                'name' => 'Dungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 5,
            ),
            406 => 
            array (
                'id' => 411,
                'name' => 'Demba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            407 => 
            array (
                'id' => 412,
                'name' => 'Mutoto',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            408 => 
            array (
                'id' => 413,
                'name' => 'Lubunga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 10:31:32',
                'province_id' => 25,
            ),
            409 => 
            array (
                'id' => 414,
                'name' => 'Kananga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 8,
            ),
            410 => 
            array (
                'id' => 415,
                'name' => 'Maluku II',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 10,
            ),
            411 => 
            array (
                'id' => 416,
                'name' => 'Nselo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 11,
            ),
            412 => 
            array (
                'id' => 417,
                'name' => 'Lomela',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 21,
            ),
            413 => 
            array (
                'id' => 418,
                'name' => 'Nioki',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 16,
            ),
            414 => 
            array (
                'id' => 419,
                'name' => 'Bolobo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 16,
            ),
            415 => 
            array (
                'id' => 420,
                'name' => 'Mushie',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 16,
            ),
            416 => 
            array (
                'id' => 421,
                'name' => 'Kwamouth',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 16,
            ),
            417 => 
            array (
                'id' => 422,
                'name' => 'Mokala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 13,
            ),
            418 => 
            array (
                'id' => 423,
                'name' => 'Kisanji',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:09',
                'updated_at' => '2020-08-06 09:45:09',
                'province_id' => 12,
            ),
            419 => 
            array (
                'id' => 424,
                'name' => 'Lukonga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 8,
            ),
            420 => 
            array (
                'id' => 425,
                'name' => 'Tunda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 17,
            ),
            421 => 
            array (
                'id' => 426,
                'name' => 'Bosobolo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 20,
            ),
            422 => 
            array (
                'id' => 427,
                'name' => 'Businga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 20,
            ),
            423 => 
            array (
                'id' => 428,
                'name' => 'Boto',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 23,
            ),
            424 => 
            array (
                'id' => 429,
                'name' => 'Lisala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 18,
            ),
            425 => 
            array (
                'id' => 430,
                'name' => 'Ndage',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 23,
            ),
            426 => 
            array (
                'id' => 431,
                'name' => 'Mwela Lembwa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 12,
            ),
            427 => 
            array (
                'id' => 432,
                'name' => 'Likati',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 1,
            ),
            428 => 
            array (
                'id' => 433,
                'name' => 'Yahuma',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 25,
            ),
            429 => 
            array (
                'id' => 434,
                'name' => 'Ikela',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 26,
            ),
            430 => 
            array (
                'id' => 435,
                'name' => 'Ubundu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 25,
            ),
            431 => 
            array (
                'id' => 436,
                'name' => 'Kailo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 17,
            ),
            432 => 
            array (
                'id' => 437,
                'name' => 'Ototo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 21,
            ),
            433 => 
            array (
                'id' => 438,
                'name' => 'Tshumbe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 21,
            ),
            434 => 
            array (
                'id' => 439,
                'name' => 'Lusangi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 17,
            ),
            435 => 
            array (
                'id' => 440,
                'name' => 'Bobozo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 8,
            ),
            436 => 
            array (
                'id' => 441,
                'name' => 'Punia',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 17,
            ),
            437 => 
            array (
                'id' => 442,
                'name' => 'Kyondo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            438 => 
            array (
                'id' => 443,
                'name' => 'Mabalako',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            439 => 
            array (
                'id' => 444,
                'name' => 'Biena',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            440 => 
            array (
                'id' => 445,
                'name' => 'Masereka',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            441 => 
            array (
                'id' => 446,
                'name' => 'Lubero',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            442 => 
            array (
                'id' => 447,
                'name' => 'Manguredjipa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            443 => 
            array (
                'id' => 448,
                'name' => 'Mutwanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            444 => 
            array (
                'id' => 449,
                'name' => 'Kamango',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            445 => 
            array (
                'id' => 450,
                'name' => 'Oicha',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            446 => 
            array (
                'id' => 451,
                'name' => 'Binza',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            447 => 
            array (
                'id' => 452,
                'name' => 'Rwanguba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            448 => 
            array (
                'id' => 453,
                'name' => 'Birambizo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            449 => 
            array (
                'id' => 454,
                'name' => 'Vuhovi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            450 => 
            array (
                'id' => 455,
                'name' => 'Musienene',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            451 => 
            array (
                'id' => 456,
                'name' => 'Katwa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            452 => 
            array (
                'id' => 457,
                'name' => 'Kayna',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            453 => 
            array (
                'id' => 458,
                'name' => 'Kibua',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            454 => 
            array (
                'id' => 459,
                'name' => 'Masisi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            455 => 
            array (
                'id' => 460,
                'name' => 'Mweso',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            456 => 
            array (
                'id' => 461,
                'name' => 'Kirotshe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            457 => 
            array (
                'id' => 462,
                'name' => 'Pinga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            458 => 
            array (
                'id' => 463,
                'name' => 'Kibirizi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            459 => 
            array (
                'id' => 464,
                'name' => 'Kalunguta',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            460 => 
            array (
                'id' => 465,
                'name' => 'Alimbongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            461 => 
            array (
                'id' => 466,
                'name' => 'Nyiragongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            462 => 
            array (
                'id' => 467,
                'name' => 'Katoyi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            463 => 
            array (
                'id' => 468,
                'name' => 'Bambo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            464 => 
            array (
                'id' => 469,
                'name' => 'Itebero',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 19,
            ),
            465 => 
            array (
                'id' => 470,
                'name' => 'Mwana',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            466 => 
            array (
                'id' => 471,
                'name' => 'Kaziba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            467 => 
            array (
                'id' => 472,
                'name' => 'Nyangezi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            468 => 
            array (
                'id' => 473,
                'name' => 'Mubumbano',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            469 => 
            array (
                'id' => 474,
                'name' => 'Walungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            470 => 
            array (
                'id' => 475,
                'name' => 'Hauts-Plateaux',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            471 => 
            array (
                'id' => 476,
                'name' => 'Kaniola',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            472 => 
            array (
                'id' => 477,
                'name' => 'Kalonge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            473 => 
            array (
                'id' => 478,
                'name' => 'Bunyakiri',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            474 => 
            array (
                'id' => 479,
                'name' => 'Kitutu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            475 => 
            array (
                'id' => 480,
                'name' => 'Kamituga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            476 => 
            array (
                'id' => 481,
                'name' => 'Itombwe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            477 => 
            array (
                'id' => 482,
                'name' => 'Minembwe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            478 => 
            array (
                'id' => 483,
                'name' => 'Nundu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            479 => 
            array (
                'id' => 484,
                'name' => 'Ruzizi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            480 => 
            array (
                'id' => 485,
                'name' => 'Lemera',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            481 => 
            array (
                'id' => 486,
                'name' => 'Shabunda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            482 => 
            array (
                'id' => 487,
                'name' => 'Lulingu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            483 => 
            array (
                'id' => 488,
                'name' => 'Kalole',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            484 => 
            array (
                'id' => 489,
                'name' => 'Mwenga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            485 => 
            array (
                'id' => 490,
                'name' => 'Mulungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            486 => 
            array (
                'id' => 491,
                'name' => 'Katana',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            487 => 
            array (
                'id' => 492,
                'name' => 'Kafakumba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            488 => 
            array (
                'id' => 493,
                'name' => 'Kanzenze',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            489 => 
            array (
                'id' => 494,
                'name' => 'Kasaji',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            490 => 
            array (
                'id' => 495,
                'name' => 'Dilolo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            491 => 
            array (
                'id' => 496,
                'name' => 'Sandoa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            492 => 
            array (
                'id' => 497,
                'name' => 'Kalamba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            493 => 
            array (
                'id' => 498,
                'name' => 'Lubudi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            494 => 
            array (
                'id' => 499,
                'name' => 'Bunkeya',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            495 => 
            array (
                'id' => 500,
                'name' => 'Kambove',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            496 => 
            array (
                'id' => 501,
                'name' => 'Kipushi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            497 => 
            array (
                'id' => 502,
                'name' => 'Kafubu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            498 => 
            array (
                'id' => 503,
                'name' => 'Kilela Balanda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            499 => 
            array (
                'id' => 504,
                'name' => 'Manika',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
        ));
        DB::table('health_zones')->insert(array (
            0 => 
            array (
                'id' => 505,
                'name' => 'Vangu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            1 => 
            array (
                'id' => 506,
                'name' => 'Kowe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            2 => 
            array (
                'id' => 507,
                'name' => 'Mitwaba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            3 => 
            array (
                'id' => 508,
                'name' => 'Minova',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            4 => 
            array (
                'id' => 509,
                'name' => 'Kalehe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            5 => 
            array (
                'id' => 510,
                'name' => 'Miti-Murhesa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            6 => 
            array (
                'id' => 511,
                'name' => 'Idjwi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            7 => 
            array (
                'id' => 512,
                'name' => 'Aba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 5,
            ),
            8 => 
            array (
                'id' => 513,
                'name' => 'Masina II',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 10,
            ),
            9 => 
            array (
                'id' => 514,
                'name' => 'Kapanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            10 => 
            array (
                'id' => 515,
                'name' => 'Dilala',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            11 => 
            array (
                'id' => 516,
                'name' => 'Mutshatsha',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 15,
            ),
            12 => 
            array (
                'id' => 517,
                'name' => 'Kikula',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            13 => 
            array (
                'id' => 518,
                'name' => 'Kimbi Lulenge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 22,
            ),
            14 => 
            array (
                'id' => 519,
                'name' => 'Ferekeni',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 17,
            ),
            15 => 
            array (
                'id' => 520,
                'name' => 'Wapinda',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 20,
            ),
            16 => 
            array (
                'id' => 521,
                'name' => 'Kasenga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 3,
            ),
            17 => 
            array (
                'id' => 522,
                'name' => 'Ntandembelo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 16,
            ),
            18 => 
            array (
                'id' => 523,
                'name' => 'Yumbi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 16,
            ),
            19 => 
            array (
                'id' => 524,
                'name' => 'Tshudi Loto',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 21,
            ),
            20 => 
            array (
                'id' => 525,
                'name' => 'Kiri',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 16,
            ),
            21 => 
            array (
                'id' => 526,
                'name' => 'Bosanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 26,
            ),
            22 => 
            array (
                'id' => 527,
                'name' => 'Yalifafo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 26,
            ),
            23 => 
            array (
                'id' => 528,
                'name' => 'Dekese',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:10',
                'updated_at' => '2020-08-06 09:45:10',
                'province_id' => 7,
            ),
            24 => 
            array (
                'id' => 529,
                'name' => 'Mimia',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 16,
            ),
            25 => 
            array (
                'id' => 530,
                'name' => 'Makanza',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            26 => 
            array (
                'id' => 531,
                'name' => 'Bomongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            27 => 
            array (
                'id' => 532,
                'name' => 'Lolanga Mampoko',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            28 => 
            array (
                'id' => 533,
                'name' => 'Penjwa',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 16,
            ),
            29 => 
            array (
                'id' => 534,
                'name' => 'Bokungu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 26,
            ),
            30 => 
            array (
                'id' => 535,
                'name' => 'Wema',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 26,
            ),
            31 => 
            array (
                'id' => 536,
                'name' => 'Befale',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 26,
            ),
            32 => 
            array (
                'id' => 537,
                'name' => 'Lotumbe',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            33 => 
            array (
                'id' => 538,
                'name' => 'Monkoto',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 26,
            ),
            34 => 
            array (
                'id' => 539,
                'name' => 'Djombo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            35 => 
            array (
                'id' => 540,
                'name' => 'Bongandanga',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 18,
            ),
            36 => 
            array (
                'id' => 541,
                'name' => 'Lingomo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 26,
            ),
            37 => 
            array (
                'id' => 542,
                'name' => 'Basankusu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            38 => 
            array (
                'id' => 543,
                'name' => 'Boende',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 26,
            ),
            39 => 
            array (
                'id' => 544,
                'name' => 'Mompono',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 26,
            ),
            40 => 
            array (
                'id' => 545,
                'name' => 'Monieka',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            41 => 
            array (
                'id' => 546,
                'name' => 'Banjow Moke',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 16,
            ),
            42 => 
            array (
                'id' => 547,
                'name' => 'Inongo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 16,
            ),
            43 => 
            array (
                'id' => 548,
                'name' => 'Bolenge',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            44 => 
            array (
                'id' => 549,
                'name' => 'Bolomba',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            45 => 
            array (
                'id' => 550,
                'name' => 'Ingende',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            46 => 
            array (
                'id' => 551,
                'name' => 'Iboko',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            47 => 
            array (
                'id' => 552,
                'name' => 'Irebu',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            48 => 
            array (
                'id' => 553,
                'name' => 'Mbandaka',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            49 => 
            array (
                'id' => 554,
                'name' => 'Lukolela',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            50 => 
            array (
                'id' => 555,
                'name' => 'Bikoro',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            51 => 
            array (
                'id' => 556,
                'name' => 'Ntondo',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
            52 => 
            array (
                'id' => 557,
                'name' => 'Lilanga Bobangi',
                'latitude' => NULL,
                'longitude' => NULL,
                'created_at' => '2020-08-06 09:45:11',
                'updated_at' => '2020-08-06 09:45:11',
                'province_id' => 2,
            ),
        ));
    }
}