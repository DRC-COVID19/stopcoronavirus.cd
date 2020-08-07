<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FluxZonesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('flux_zones')->truncate();
        DB::table('flux_zones')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Aba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Adi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Alimbongo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'Angumu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'Ankoro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'Ariwara',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 =>
            array(
                'id' => 7,
                'name' => 'Bafwasende',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 =>
            array(
                'id' => 8,
                'name' => 'Baka',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 =>
            array(
                'id' => 9,
                'name' => 'Banalia',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 =>
            array(
                'id' => 10,
                'name' => 'Barumbu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 =>
            array(
                'id' => 11,
                'name' => 'Basoko',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 =>
            array(
                'id' => 12,
                'name' => 'Bena Leka',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 =>
            array(
                'id' => 13,
                'name' => 'Bena Tshiadi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 =>
            array(
                'id' => 14,
                'name' => 'Bengamisa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 =>
            array(
                'id' => 15,
                'name' => 'Beni',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 =>
            array(
                'id' => 16,
                'name' => 'Bibanga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 =>
            array(
                'id' => 17,
                'name' => 'Biena',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 =>
            array(
                'id' => 18,
                'name' => 'Bikoro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 =>
            array(
                'id' => 19,
                'name' => 'Bilomba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 =>
            array(
                'id' => 20,
                'name' => 'Binga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 =>
            array(
                'id' => 21,
                'name' => 'Binza',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 =>
            array(
                'id' => 22,
                'name' => 'Binza Meteo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 =>
            array(
                'id' => 23,
                'name' => 'Binza Ozone',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 =>
            array(
                'id' => 24,
                'name' => 'Birambizo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 =>
            array(
                'id' => 25,
                'name' => 'Boko',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 =>
            array(
                'id' => 26,
                'name' => 'Boko-Kivulu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 =>
            array(
                'id' => 27,
                'name' => 'Bokoro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 =>
            array(
                'id' => 28,
                'name' => 'Bolobo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 =>
            array(
                'id' => 29,
                'name' => 'Bolomba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 =>
            array(
                'id' => 30,
                'name' => 'Boma',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 =>
            array(
                'id' => 31,
                'name' => 'Boma Bungu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 =>
            array(
                'id' => 32,
                'name' => 'Bominenge',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 =>
            array(
                'id' => 33,
                'name' => 'Bosondjo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 =>
            array(
                'id' => 34,
                'name' => 'Bukama',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 =>
            array(
                'id' => 35,
                'name' => 'Bulungu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 =>
            array(
                'id' => 36,
                'name' => 'Bumba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 =>
            array(
                'id' => 37,
                'name' => 'Bumbu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 =>
            array(
                'id' => 38,
                'name' => 'Bunia',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 =>
            array(
                'id' => 39,
                'name' => 'Bunkeya',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 =>
            array(
                'id' => 40,
                'name' => 'Bunkonde',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 =>
            array(
                'id' => 41,
                'name' => 'Bunyakiri',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 =>
            array(
                'id' => 42,
                'name' => 'Businga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 =>
            array(
                'id' => 43,
                'name' => 'Buta',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 =>
            array(
                'id' => 44,
                'name' => 'Cilundu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 =>
            array(
                'id' => 45,
                'name' => 'Demba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 =>
            array(
                'id' => 46,
                'name' => 'Dibaya',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 =>
            array(
                'id' => 47,
                'name' => 'Dilala',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 =>
            array(
                'id' => 48,
                'name' => 'Dilolo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 =>
            array(
                'id' => 49,
                'name' => 'Diulu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 =>
            array(
                'id' => 50,
                'name' => 'Djalo Djeka',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 =>
            array(
                'id' => 51,
                'name' => 'Djuma',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 =>
            array(
                'id' => 52,
                'name' => 'Drodro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 =>
            array(
                'id' => 53,
                'name' => 'Fizi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 =>
            array(
                'id' => 54,
                'name' => 'Fungurume',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 =>
            array(
                'id' => 55,
                'name' => 'Gbadolite',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 =>
            array(
                'id' => 56,
                'name' => 'Gemena',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 =>
            array(
                'id' => 57,
                'name' => 'Gethy',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 =>
            array(
                'id' => 58,
                'name' => 'Gombari',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 =>
            array(
                'id' => 59,
                'name' => 'Gombe',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 =>
            array(
                'id' => 60,
                'name' => 'Hauts-Plateaux',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 =>
            array(
                'id' => 61,
                'name' => 'Hors_Zone',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 =>
            array(
                'id' => 62,
                'name' => 'Ibanda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 =>
            array(
                'id' => 63,
                'name' => 'Idiofa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 =>
            array(
                'id' => 64,
                'name' => 'Idjwi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 =>
            array(
                'id' => 65,
                'name' => 'Ilebo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 =>
            array(
                'id' => 66,
                'name' => 'Inga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 =>
            array(
                'id' => 67,
                'name' => 'Isangi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 =>
            array(
                'id' => 68,
                'name' => 'Isiro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 =>
            array(
                'id' => 69,
                'name' => 'Itebero',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 =>
            array(
                'id' => 70,
                'name' => 'Itombwe',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 =>
            array(
                'id' => 71,
                'name' => 'Kabambare',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 =>
            array(
                'id' => 72,
                'name' => 'Kabare',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 =>
            array(
                'id' => 73,
                'name' => 'Kabeya Kamuanga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 =>
            array(
                'id' => 74,
                'name' => 'Kabinda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 =>
            array(
                'id' => 75,
                'name' => 'Kabondo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 =>
            array(
                'id' => 76,
                'name' => 'Kabondo Dianda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 =>
            array(
                'id' => 77,
                'name' => 'Kabongo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 =>
            array(
                'id' => 78,
                'name' => 'Kahemba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 =>
            array(
                'id' => 79,
                'name' => 'Kalamba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 =>
            array(
                'id' => 80,
                'name' => 'Kalamu I',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 =>
            array(
                'id' => 81,
                'name' => 'Kalamu II',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 =>
            array(
                'id' => 82,
                'name' => 'Kalemie',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 =>
            array(
                'id' => 83,
                'name' => 'Kalenda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 =>
            array(
                'id' => 84,
                'name' => 'Kalima',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 =>
            array(
                'id' => 85,
                'name' => 'Kalole',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 =>
            array(
                'id' => 86,
                'name' => 'Kalonda Ouest',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 =>
            array(
                'id' => 87,
                'name' => 'Kalonge',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 =>
            array(
                'id' => 88,
                'name' => 'Kamango',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 =>
            array(
                'id' => 89,
                'name' => 'Kamiji',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            89 =>
            array(
                'id' => 90,
                'name' => 'Kamina',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            90 =>
            array(
                'id' => 91,
                'name' => 'Kamituga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            91 =>
            array(
                'id' => 92,
                'name' => 'Kamonia',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            92 =>
            array(
                'id' => 93,
                'name' => 'Kampemba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            93 =>
            array(
                'id' => 94,
                'name' => 'Kampene',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            94 =>
            array(
                'id' => 95,
                'name' => 'Kamwesha',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            95 =>
            array(
                'id' => 96,
                'name' => 'Kananga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            96 =>
            array(
                'id' => 97,
                'name' => 'Kanda Kanda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            97 =>
            array(
                'id' => 98,
                'name' => 'Kangu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            98 =>
            array(
                'id' => 99,
                'name' => 'Kaniama',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            99 =>
            array(
                'id' => 100,
                'name' => 'Kanzenze',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            100 =>
            array(
                'id' => 101,
                'name' => 'Kapolowe',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            101 =>
            array(
                'id' => 102,
                'name' => 'Karawa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            102 =>
            array(
                'id' => 103,
                'name' => 'Karisimbi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            103 =>
            array(
                'id' => 104,
                'name' => 'Kasa-Vubu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            104 =>
            array(
                'id' => 105,
                'name' => 'Kasaji',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            105 =>
            array(
                'id' => 106,
                'name' => 'Kasansa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            106 =>
            array(
                'id' => 107,
                'name' => 'Kashobwe',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            107 =>
            array(
                'id' => 108,
                'name' => 'Kasongo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            108 =>
            array(
                'id' => 109,
                'name' => 'Katako Kombe',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            109 =>
            array(
                'id' => 110,
                'name' => 'Katana',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            110 =>
            array(
                'id' => 111,
                'name' => 'Katwa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            111 =>
            array(
                'id' => 112,
                'name' => 'Kayna',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            112 =>
            array(
                'id' => 113,
                'name' => 'Kenge',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            113 =>
            array(
                'id' => 114,
                'name' => 'Kibirizi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            114 =>
            array(
                'id' => 115,
                'name' => 'Kibunzi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            115 =>
            array(
                'id' => 116,
                'name' => 'Kikimi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            116 =>
            array(
                'id' => 117,
                'name' => 'Kikongo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            117 =>
            array(
                'id' => 118,
                'name' => 'Kikula',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            118 =>
            array(
                'id' => 119,
                'name' => 'Kikwit-Sud',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            119 =>
            array(
                'id' => 120,
                'name' => 'Kilwa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            120 =>
            array(
                'id' => 121,
                'name' => 'Kimbanseke',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            121 =>
            array(
                'id' => 122,
                'name' => 'Kimpangu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            122 =>
            array(
                'id' => 123,
                'name' => 'Kimpese',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            123 =>
            array(
                'id' => 124,
                'name' => 'Kinda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            124 =>
            array(
                'id' => 125,
                'name' => 'Kindu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            125 =>
            array(
                'id' => 126,
                'name' => 'Kingabwa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            126 =>
            array(
                'id' => 127,
                'name' => 'Kinkonzi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            127 =>
            array(
                'id' => 128,
                'name' => 'Kinshasa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            128 =>
            array(
                'id' => 129,
                'name' => 'Kintambo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            129 =>
            array(
                'id' => 130,
                'name' => 'Kipushi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            130 =>
            array(
                'id' => 131,
                'name' => 'Kirotshe',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            131 =>
            array(
                'id' => 132,
                'name' => 'Kisantu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            132 =>
            array(
                'id' => 133,
                'name' => 'Kisenso',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            133 =>
            array(
                'id' => 134,
                'name' => 'Kitangwa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            134 =>
            array(
                'id' => 135,
                'name' => 'Kitenda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            135 =>
            array(
                'id' => 136,
                'name' => 'Kitenge',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            136 =>
            array(
                'id' => 137,
                'name' => 'Kitona',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            137 =>
            array(
                'id' => 138,
                'name' => 'Kokolo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            138 =>
            array(
                'id' => 139,
                'name' => 'Kole',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            139 =>
            array(
                'id' => 140,
                'name' => 'Komanda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            140 =>
            array(
                'id' => 141,
                'name' => 'Kuimba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            141 =>
            array(
                'id' => 142,
                'name' => 'Kwilu-Ngongo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            142 =>
            array(
                'id' => 143,
                'name' => 'Kyondo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            143 =>
            array(
                'id' => 144,
                'name' => 'Lemba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            144 =>
            array(
                'id' => 145,
                'name' => 'Lemera',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            145 =>
            array(
                'id' => 146,
                'name' => 'Likasi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            146 =>
            array(
                'id' => 147,
                'name' => 'Limete',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            147 =>
            array(
                'id' => 148,
                'name' => 'Lisala',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            148 =>
            array(
                'id' => 149,
                'name' => 'Lodja',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            149 =>
            array(
                'id' => 150,
                'name' => 'Logo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            150 =>
            array(
                'id' => 151,
                'name' => 'Loko',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            151 =>
            array(
                'id' => 152,
                'name' => 'Lualaba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            152 =>
            array(
                'id' => 153,
                'name' => 'Luambo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            153 =>
            array(
                'id' => 154,
                'name' => 'Lubero',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            154 =>
            array(
                'id' => 155,
                'name' => 'Lubondaie',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            155 =>
            array(
                'id' => 156,
                'name' => 'Lubudi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            156 =>
            array(
                'id' => 157,
                'name' => 'Lubumbashi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            157 =>
            array(
                'id' => 158,
                'name' => 'Lubunga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            158 =>
            array(
                'id' => 159,
                'name' => 'Ludimbi Lukula',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            159 =>
            array(
                'id' => 160,
                'name' => 'Luebo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            160 =>
            array(
                'id' => 161,
                'name' => 'Luiza',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            161 =>
            array(
                'id' => 162,
                'name' => 'Lukula',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            162 =>
            array(
                'id' => 163,
                'name' => 'Luozi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            163 =>
            array(
                'id' => 164,
                'name' => 'Luputa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            164 =>
            array(
                'id' => 165,
                'name' => 'Lusangi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            165 =>
            array(
                'id' => 166,
                'name' => 'Lwamba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            166 =>
            array(
                'id' => 167,
                'name' => 'Mahagi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            167 =>
            array(
                'id' => 168,
                'name' => 'Makala',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            168 =>
            array(
                'id' => 169,
                'name' => 'Makiso-Kisangani',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            169 =>
            array(
                'id' => 170,
                'name' => 'Malemba Nkulu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            170 =>
            array(
                'id' => 171,
                'name' => 'Maluku I',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            171 =>
            array(
                'id' => 172,
                'name' => 'Mambasa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            172 =>
            array(
                'id' => 173,
                'name' => 'Mangembo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            173 =>
            array(
                'id' => 174,
                'name' => 'Manguredjipa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            174 =>
            array(
                'id' => 175,
                'name' => 'Manika',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            175 =>
            array(
                'id' => 176,
                'name' => 'Masa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            176 =>
            array(
                'id' => 177,
                'name' => 'Masereka',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            177 =>
            array(
                'id' => 178,
                'name' => 'Masina I',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            178 =>
            array(
                'id' => 179,
                'name' => 'Masina II',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            179 =>
            array(
                'id' => 180,
                'name' => 'Masisi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            180 =>
            array(
                'id' => 181,
                'name' => 'Masuika',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            181 =>
            array(
                'id' => 182,
                'name' => 'Matadi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            182 =>
            array(
                'id' => 183,
                'name' => 'Matete',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            183 =>
            array(
                'id' => 184,
                'name' => 'Mbanza-Ngungu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            184 =>
            array(
                'id' => 185,
                'name' => 'Miabi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            185 =>
            array(
                'id' => 186,
                'name' => 'Mikalayi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            186 =>
            array(
                'id' => 187,
                'name' => 'Minembwe',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            187 =>
            array(
                'id' => 188,
                'name' => 'Minova',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            188 =>
            array(
                'id' => 189,
                'name' => 'Moanda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            189 =>
            array(
                'id' => 190,
                'name' => 'Mokala',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            190 =>
            array(
                'id' => 191,
                'name' => 'Monga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            191 =>
            array(
                'id' => 192,
                'name' => 'Mongbalu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            192 =>
            array(
                'id' => 193,
                'name' => 'Mont Ngafula I',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            193 =>
            array(
                'id' => 194,
                'name' => 'Mont Ngafula II',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            194 =>
            array(
                'id' => 195,
                'name' => 'Mukanga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            195 =>
            array(
                'id' => 196,
                'name' => 'Mukumbi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            196 =>
            array(
                'id' => 197,
                'name' => 'Mulongo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            197 =>
            array(
                'id' => 198,
                'name' => 'Mulumba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            198 =>
            array(
                'id' => 199,
                'name' => 'Mushie',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            199 =>
            array(
                'id' => 200,
                'name' => 'Musienene',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            200 =>
            array(
                'id' => 201,
                'name' => 'Mutena',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            201 =>
            array(
                'id' => 202,
                'name' => 'Mutoto',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            202 =>
            array(
                'id' => 203,
                'name' => 'Mutshatsha',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            203 =>
            array(
                'id' => 204,
                'name' => 'Mutwanga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            204 =>
            array(
                'id' => 205,
                'name' => 'Mweka',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            205 =>
            array(
                'id' => 206,
                'name' => 'Mwene Ditu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            206 =>
            array(
                'id' => 207,
                'name' => 'Mwenga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            207 =>
            array(
                'id' => 208,
                'name' => 'Mweso',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            208 =>
            array(
                'id' => 209,
                'name' => 'Ndage',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            209 =>
            array(
                'id' => 210,
                'name' => 'Ndekesha',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            210 =>
            array(
                'id' => 211,
                'name' => 'Ndjili',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            211 =>
            array(
                'id' => 212,
                'name' => 'Ngandajika',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            212 =>
            array(
                'id' => 213,
                'name' => 'Ngidinga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            213 =>
            array(
                'id' => 214,
                'name' => 'Ngiri-Ngiri',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            214 =>
            array(
                'id' => 215,
                'name' => 'Nia-Nia',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            215 =>
            array(
                'id' => 216,
                'name' => 'Niangara',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            216 =>
            array(
                'id' => 217,
                'name' => 'Nioki',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            217 =>
            array(
                'id' => 218,
                'name' => 'Nsele',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            218 =>
            array(
                'id' => 219,
                'name' => 'Nsona-Mpangu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            219 =>
            array(
                'id' => 220,
                'name' => 'Nundu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            220 =>
            array(
                'id' => 221,
                'name' => 'Nyakunde',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            221 =>
            array(
                'id' => 222,
                'name' => 'Nyangezi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            222 =>
            array(
                'id' => 223,
                'name' => 'Nyarambe',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            223 =>
            array(
                'id' => 224,
                'name' => 'Nyemba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            224 =>
            array(
                'id' => 225,
                'name' => 'Nyiragongo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            225 =>
            array(
                'id' => 226,
                'name' => 'Oicha',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            226 =>
            array(
                'id' => 227,
                'name' => 'Omendjadi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            227 =>
            array(
                'id' => 228,
                'name' => 'Pimu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            228 =>
            array(
                'id' => 229,
                'name' => 'Poko',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            229 =>
            array(
                'id' => 230,
                'name' => 'Police',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            230 =>
            array(
                'id' => 231,
                'name' => 'Pweto',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            231 =>
            array(
                'id' => 232,
                'name' => 'Rungu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            232 =>
            array(
                'id' => 233,
                'name' => 'Rutshuru',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            233 =>
            array(
                'id' => 234,
                'name' => 'Ruzizi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            234 =>
            array(
                'id' => 235,
                'name' => 'Rwanguba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            235 =>
            array(
                'id' => 236,
                'name' => 'Rwashi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            236 =>
            array(
                'id' => 237,
                'name' => 'Sakania',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            237 =>
            array(
                'id' => 238,
                'name' => 'Samba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            238 =>
            array(
                'id' => 239,
                'name' => 'Sandoa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            239 =>
            array(
                'id' => 240,
                'name' => 'Saramabila',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            240 =>
            array(
                'id' => 241,
                'name' => 'Seke-Banza',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            241 =>
            array(
                'id' => 242,
                'name' => 'Selembao',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            242 =>
            array(
                'id' => 243,
                'name' => 'Shabunda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            243 =>
            array(
                'id' => 244,
                'name' => 'Sona-Bata',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            244 =>
            array(
                'id' => 245,
                'name' => 'Tandala',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            245 =>
            array(
                'id' => 246,
                'name' => 'Tembo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            246 =>
            array(
                'id' => 247,
                'name' => 'Tshamilemba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            247 =>
            array(
                'id' => 248,
                'name' => 'Tshela',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            248 =>
            array(
                'id' => 249,
                'name' => 'Tshikapa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            249 =>
            array(
                'id' => 250,
                'name' => 'Tshilenge',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            250 =>
            array(
                'id' => 251,
                'name' => 'Tshishimbi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            251 =>
            array(
                'id' => 252,
                'name' => 'Ubundu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            252 =>
            array(
                'id' => 253,
                'name' => 'Uvira',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            253 =>
            array(
                'id' => 254,
                'name' => 'Vaku',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            254 =>
            array(
                'id' => 255,
                'name' => 'Vanga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            255 =>
            array(
                'id' => 256,
                'name' => 'Vanga Kete',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            256 =>
            array(
                'id' => 257,
                'name' => 'Vuhovi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            257 =>
            array(
                'id' => 258,
                'name' => 'Walungu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            258 =>
            array(
                'id' => 259,
                'name' => 'Wamba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            259 =>
            array(
                'id' => 260,
                'name' => 'Wangata',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            260 =>
            array(
                'id' => 261,
                'name' => 'Wanierukula',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            261 =>
            array(
                'id' => 262,
                'name' => 'Watsa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            262 =>
            array(
                'id' => 263,
                'name' => 'Yabaondo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            263 =>
            array(
                'id' => 264,
                'name' => 'Yahuma',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            264 =>
            array(
                'id' => 265,
                'name' => 'Yakusu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            265 =>
            array(
                'id' => 266,
                'name' => 'Yambuku',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            266 =>
            array(
                'id' => 267,
                'name' => 'Yangala',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            267 =>
            array(
                'id' => 268,
                'name' => 'Zongo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            268 =>
            array(
                'id' => 269,
                'name' => 'Aru',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            269 =>
            array(
                'id' => 270,
                'name' => 'Boende',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            270 =>
            array(
                'id' => 271,
                'name' => 'Bondo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            271 =>
            array(
                'id' => 272,
                'name' => 'Bongandanga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            272 =>
            array(
                'id' => 273,
                'name' => 'Dungu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            273 =>
            array(
                'id' => 274,
                'name' => 'Feshi',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            274 =>
            array(
                'id' => 275,
                'name' => 'Gungu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            275 =>
            array(
                'id' => 276,
                'name' => 'Kafakumba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            276 =>
            array(
                'id' => 277,
                'name' => 'Kongolo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            277 =>
            array(
                'id' => 278,
                'name' => 'Kunda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            278 =>
            array(
                'id' => 279,
                'name' => 'Likati',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            279 =>
            array(
                'id' => 280,
                'name' => 'Lolo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            280 =>
            array(
                'id' => 281,
                'name' => 'Lubao',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            281 =>
            array(
                'id' => 282,
                'name' => 'Mangala',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            282 =>
            array(
                'id' => 283,
                'name' => 'Manono',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            283 =>
            array(
                'id' => 284,
                'name' => 'Moba',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            284 =>
            array(
                'id' => 285,
                'name' => 'Mufunga Sampwe',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            285 =>
            array(
                'id' => 286,
                'name' => 'Ototo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            286 =>
            array(
                'id' => 287,
                'name' => 'Punia',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            287 =>
            array(
                'id' => 288,
                'name' => 'Tshofa',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            288 =>
            array(
                'id' => 289,
                'name' => 'Yaleko',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            289 =>
            array(
                'id' => 290,
                'name' => 'Kasongo Lunda',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            290 =>
            array(
                'id' => 291,
                'name' => 'Kabalo',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            291 =>
            array(
                'id' => 292,
                'name' => 'Lomela',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            292 =>
            array(
                'id' => 293,
                'name' => 'Yamongili',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            293 =>
            array(
                'id' => 294,
                'name' => 'Minga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            294 =>
            array(
                'id' => 295,
                'name' => 'Tshumbe',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            295 =>
            array(
                'id' => 296,
                'name' => 'Kapanga',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            296 =>
            array(
                'id' => 297,
                'name' => 'Dikungu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            297 =>
            array(
                'id' => 298,
                'name' => 'Wembo Nyama',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            298 =>
            array(
                'id' => 299,
                'name' => 'Mikope',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            299 =>
            array(
                'id' => 300,
                'name' => 'Banga Lubaka',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            300 =>
            array(
                'id' => 301,
                'name' => 'Lubutu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            301 =>
            array(
                'id' => 302,
                'name' => 'Kalonda Est',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            302 =>
            array(
                'id' => 303,
                'name' => 'Kitutu',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            303 =>
            array(
                'id' => 304,
                'name' => 'Bangabola',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            304 =>
            array(
                'id' => 305,
                'name' => 'Kinkondja',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }
}
