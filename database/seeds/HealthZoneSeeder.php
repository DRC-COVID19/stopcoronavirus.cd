<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HealthZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('health_zones')->truncate();
        DB::table('health_zones')->insert([
            ["name" => "Gombe"],
            ["name" => "Binza Ozone"],
            ["name" => "Limete"],
            ["name" => "Kokolo (Ndolo)"],
            ["name" => "Binza Méteo"],
            ["name" => "Lemba"],
            ["name" => "Kalamu 1"],
            ["name" => "Lingwala"],
            ["name" => "Kintambo"],
            ["name" => "Matete"],
            ["name" => "Kingabwa"],
            ["name" => "Kasa-vubu"],
            ["name" => "Kinshasa"],
            ["name" => "Bandalungwa"],
            ["name" => "Barumbu"],
            ["name" => "N'sele"],
            ["name" => "Selembao"],
            ["name" => "Bumbu"],
            ["name" => "Ngiri-Ngiri"],
            ["name" => "Mont-Ngafula 1"],
            ["name" => "Mont-Ngafula 2"],
            ["name" => "Kalamu 2"],
            ["name" => "Masina 1"],
            ["name" => "Kikimi"],
            ["name" => "Maluku 1"],
            ["name" => "N'djili"],
            ["name" => "Makala"],
            ["name" => "Ngaba"],
            ["name" => "Masina 2"],
            ["name" => "Kisenso"],
            ["name" => "Kimbanseke"],
            ["name" => "Zone indeterminée"],
            ["name" => "Goma"],
            ["name" => "Beni"],
            ["name" => "Butembo"],
            ["name" => "Ibanda"],
            ["name" => "Nyankunde"],
            ["name" => "Bunia"],
            ["name" => "Idiofa"],
            ["name" => "Kenya"],
            ["name" => "Tshamilemba"],
            ["name" => "Kasumbalesa"],
            ["name" => "Matadi"],
            ["name" => "Nzanza"]
        ]);
    }
}
