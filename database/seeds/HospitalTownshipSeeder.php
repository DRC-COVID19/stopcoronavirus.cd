<?php

use Illuminate\Database\Seeder;
use App\Hospital;

class HospitalTownshipSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //
    for ($i = 1; $i < 13; $i++) {
      $hospital = Hospital::find($i);
      if ($i == 1 || $i == 2) {
        $hospital->township()->associate(21);
      } elseif ($i == 3) {
        $hospital->township()->associate(18);
      } elseif ($i == 4) {
        $hospital->township()->associate(12);
      } elseif ($i == 5) {
        $hospital->township()->associate(11);
      } elseif ($i == 6) {
        $hospital->township()->associate(13);
      } elseif ($i == 7) {
        $hospital->township()->associate(8);
      } elseif ($i == 8 || $i == 12) {
        $hospital->township()->associate(4);
      } elseif ($i == 9) {
        $hospital->township()->associate(6);
      } elseif ($i == 10) {
        $hospital->township()->associate(23);
      } elseif ($i == 11) {
        $hospital->township()->associate(19);
      }
      $hospital->save();
    }
  }
}
