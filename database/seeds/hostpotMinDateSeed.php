<?php

use App\Flux30ZoneSumByDate;
use App\FluxHotSpot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class hostpotMinDateSeed extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    try {
      DB::beginTransaction();
      $hotspot = FluxHotSpot::all();
      foreach ($hotspot as $value) {
        $fluxElement = Flux30ZoneSumByDate::select('date')->where('observation_zone', $value->name)->orderBy('date')->first();
        $value->min_date = $fluxElement->date;
        $value->save();
      }
      DB::commit();
    } catch (\Throwable $th) {
      DB::rollback();
      throw $th;
    }
  }
}
