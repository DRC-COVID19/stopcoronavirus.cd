<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('hospitals')->insert([
      [
        'name' => 'Centre Hospitalier Monkole',
        'latitude' => '-4.42543',
        'longitude' => '15.28591',
        'address' => '',
      ],
      [
        'name' => 'Clinique Ngaliema',
        'latitude' => '-4.31435',
        'longitude' => '15.27123',
        'address' => '',
      ],
      [
        'name' => 'Hôpital Saint Joseph',
        'latitude' => '-4.36593',
        'longitude' => '15.3408',
        'address' => '',
      ],
      [
        'name' => 'Cliniques universitaires de Kinshasa',
        'latitude' => '-4.41405',
        'longitude' => '15.30541',
        'address' => '',
      ],
      [
        'name' => 'Hopital de l’Amitie Sino-Congolaise',
        'latitude' => '-4.40364',
        'longitude' => '15.37435',
        'address' => '',
      ],
    ]);
  }
}
