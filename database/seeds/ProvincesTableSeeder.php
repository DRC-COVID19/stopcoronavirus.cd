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

    DB::table('provinces')->insert([
      0 => [
        'id' => 1,
        'name' => 'Bas-Uele',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '3.9901009',
        'longitude' => '24.9042208',
      ],
      1 => [
        'id' => 2,
        'name' => 'Equateur',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '3.9901009',
        'longitude' => '24.9042208',
      ],
      2 => [
        'id' => 3,
        'name' => 'Haut-Katanga',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-10.4102075',
        'longitude' => '27.5495846',
      ],
      3 => [
        'id' => 4,
        'name' => 'Haut-Lomami',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-7.705275199999998',
        'longitude' => '24.9042208',
      ],
      4 => [
        'id' => 5,
        'name' => 'Haut-Uele',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '3.5845154',
        'longitude' => '28.299435',
      ],
      5 => [
        'id' => 6,
        'name' => 'Ituri',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '1.85',
        'longitude' => '29.966667',
      ],
      6 => [
        'id' => 7,
        'name' => 'Kasaï',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-5.0471979',
        'longitude' => '20.7122465',
      ],
      7 => [
        'id' => 8,
        'name' => 'Kasaï-Central',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-6.2514921',
        'longitude' => '22.2384017',
      ],
      8 => [
        'id' => 9,
        'name' => 'Kasaï-Oriental',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-6.2514921',
        'longitude' => '22.2384017',
      ],
      9 => [
        'id' => 10,
        'name' => 'Kinshasa',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-4.4419311',
        'longitude' => '15.2662931',
      ],
      10 => [
        'id' => 11,
        'name' => 'Kongo-Central',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-5.2365685',
        'longitude' => '13.914399',
      ],
      11 => [
        'id' => 12,
        'name' => 'Kwango',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-6.4337409',
        'longitude' => '17.668887',
      ],
      12 => [
        'id' => 13,
        'name' => 'Kwilu',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-5.1188825',
        'longitude' => '18.4276047',
      ],
      13 => [
        'id' => 14,
        'name' => 'Lomami',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-1.899681',
        'longitude' => '22.72851',
      ],
      14 => [
        'id' => 15,
        'name' => 'Lualaba',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-10.48087',
        'longitude' => '25.634159',
      ],
      15 => [
        'id' => 16,
        'name' => 'Maï-Ndombe',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-2.6357434',
        'longitude' => '18.4276047',
      ],
      16 => [
        'id' => 17,
        'name' => 'Maniema',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-1.167485',
        'longitude' => '28.61903',
      ],
      17 => [
        'id' => 18,
        'name' => 'Mongala',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '1.9962324',
        'longitude' => '21.4752851',
      ],
      18 => [
        'id' => 19,
        'name' => 'Nord-Kivu',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-0.7917729',
        'longitude' => '29.0459927',
      ],
      19 => [
        'id' => 20,
        'name' => 'Nord-Ubangi',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '3.7878726',
        'longitude' => '21.4752851',
      ],
      20 => [
        'id' => 21,
        'name' => 'Sankuru',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-2.8437453',
        'longitude' => '23.38235449999999',
      ],
      21 => [
        'id' => 22,
        'name' => 'Sud-Kivu',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-3.011658',
        'longitude' => '28.299435',
      ],
      22 => [
        'id' => 23,
        'name' => 'Sud-Ubangi',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '3.2299942',
        'longitude' => '19.1880047',
      ],
      23 => [
        'id' => 24,
        'name' => 'Tanganyika',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-6.274011799999998',
        'longitude' => '27.9249002',
      ],
      24 => [
        'id' => 25,
        'name' => 'Tshopo',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-10.21105',
        'longitude' => '24.84374',
      ],
      25 => [
        'id' => 26,
        'name' => 'Tshuapa',
        'created_at' => null,
        'updated_at' => null,
        'latitude' => '-0.9903022999999997',
        'longitude' => '23.0288844',
      ],
    ]);
  }
}
