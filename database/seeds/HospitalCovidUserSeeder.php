<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HospitalCovidUserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('admin_users')->insert([
      [
        'name' => 'AGENT NGALIEMA',
        'username' => '0893982784',
        'password' => Hash::make('ilisto'),
      ],
      [
        'name' => 'AGENT DIAMANT',
        'username' => '0897309670',
        'password' => Hash::make('aterge'),
      ],
      [
        'name' => 'AGENT MONKOLE',
        'username' => '0895339239',
        'password' => Hash::make('raviob'),
      ],
      [
        'name' => 'AGENT SAINT JOSEPH',
        'username' => '0842385942',
        'password' => Hash::make('nobens'),
      ],
      [
        'name' => 'AGENT CUK',
        'username' => '0853380233',
        'password' => Hash::make('positu'),
      ],
      [
        'name' => 'AGENT VIJANA',
        'username' => '0840597601',
        'password' => Hash::make('cticke'),
      ],
      [
        'name' => 'AGENT ZONE DE SANTE STADE DE MARTYRS',
        'username' => '0850198936',
        'password' => Hash::make('sletry'),
      ],
      [
        'name' => 'AGENT ZONE DE SANTE GHK',
        'username' => '0858867724',
        'password' => Hash::make('ceterc'),
      ],
      [
        'name' => 'AGENT CINQUANTENAIRE',
        'username' => '0858863877',
        'password' => Hash::make('acarys'),
      ],
      [
        'name' => 'AGENT KINKOLE',
        'username' => '0858527925',
        'password' => Hash::make('rentex'),
      ],
      [
        'name' => 'AGENT HASC',
        'username' => '0851632381',
        'password' => Hash::make('recton'),
      ],
      [
        'name' => 'AGENT CMK',
        'username' => '0852966794',
        'password' => Hash::make('tardin'),
      ],
    ]);
  }
}
