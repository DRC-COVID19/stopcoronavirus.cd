<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Flux30ZoneSumByDate extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('flux30_zone_sum_by_dates')->delete();
    DB::insert(
      'insert into flux30_zone_sum_by_dates (volume,date,Observation_Zone) select sum("Volume"),"Date","Observation_Zone" from flux30_zone_sums group by "Date","Observation_Zone"'
    );
  }
}
