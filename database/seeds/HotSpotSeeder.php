<?php

use Illuminate\Database\Seeder;

class HotSpotSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $this->call(FluxHotSpotsTableSeeder::class);
    $this->call(hostpotMinDateSeed::class);
    $this->call(AddHotspotypeSeeder::class);
  }
}
