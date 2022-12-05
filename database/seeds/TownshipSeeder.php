<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TownshipSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('townships')->truncate();
    DB::table('townships')->insert([
      [
        'id' => 1,
        'name' => 'Bandalungwa',
        'longitude' => '15.2792',
        'latitude' => '-4.3909',
      ],
      [
        'id' => 2,
        'name' => 'Barumbu',
        'longitude' => '15.3218',
        'latitude' => '-4.3526',
      ],
      [
        'id' => 3,
        'name' => 'Bumbu',
        'longitude' => '15.2971',
        'latitude' => '-4.4183',
      ],
      [
        'id' => 4,
        'name' => 'Gombe',
        'longitude' => '15.304',
        'latitude' => '-4.3485',
      ],
      [
        'id' => 5,
        'name' => 'Kalamu',
        'longitude' => '15.3204',
        'latitude' => '-4.3895',
      ],
      [
        'id' => 6,
        'name' => 'Kasa-Vubu',
        'longitude' => '15.5251',
        'latitude' => '-4.3854',
      ],
      [
        'id' => 7,
        'name' => 'Kimbanseke',
        'longitude' => '15.4028',
        'latitude' => '-4.484',
      ],
      [
        'id' => 8,
        'name' => 'Kinshasa',
        'longitude' => '15.3081',
        'latitude' => '-4.3663',
      ],
      [
        'id' => 9,
        'name' => 'Kintambo',
        'longitude' => '15.2724',
        'latitude' => '-4.369',
      ],
      [
        'id' => 10,
        'name' => 'Kisenso',
        'longitude' => '15.3465',
        'latitude' => '-4.4553',
      ],
      [
        'id' => 11,
        'name' => 'Lemba',
        'longitude' => '15.3342',
        'latitude' => '-4.4662',
      ],
      [
        'id' => 12,
        'name' => 'Limete',
        'longitude' => '15.3383',
        'latitude' => '-4.3923',
      ],
      [
        'id' => 13,
        'name' => 'Lingwala',
        'longitude' => '15.3012',
        'latitude' => '-4.369',
      ],
      [
        'id' => 14,
        'name' => 'Makala',
        'longitude' => '15.3094',
        'latitude' => '-4.4224',
      ],
      [
        'id' => 15,
        'name' => 'Maluku',
        'longitude' => '16.0785',
        'latitude' => '-4.5032',
      ],
      [
        'id' => 16,
        'name' => 'Masina',
        'longitude' => '15.3932',
        'latitude' => '-4.4306',
      ],
      [
        'id' => 17,
        'name' => 'Matete',
        'longitude' => '15.3534',
        'latitude' => '-4.4334',
      ],
      [
        'id' => 18,
        'name' => 'Mont-Ngafula',
        'longitude' => '15.2957',
        'latitude' => '-4.469',
      ],
      [
        'id' => 19,
        'name' => 'Ndjili',
        'longitude' => '15.374',
        'latitude' => '-4.4471',
      ],
      [
        'id' => 20,
        'name' => 'Ngaba',
        'longitude' => '15.3246',
        'latitude' => '-4.4265',
      ],
      [
        'id' => 21,
        'name' => 'Ngaliema',
        'longitude' => '15.2188',
        'latitude' => '-4.4046',
      ],
      [
        'id' => 22,
        'name' => 'Ngiri-Ngiri',
        'longitude' => '15.2985',
        'latitude' => '-4.4032',
      ],
      [
        'id' => 23,
        'name' => 'Nsele',
        'longitude' => '15.4948',
        'latitude' => '-4.4169',
      ],
      [
        'id' => 24,
        'name' => 'Selembao',
        'longitude' => '15.2861',
        'latitude' => '-4.4156',
      ],
    ]);
  }
}
