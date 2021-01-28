<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Flux30ZoneSumsAddNewIndex extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('flux30_zone_sums', function (Blueprint $table) {
      DB::statement('CREATE INDEX flux30_zone_sums_date_hour ON flux30_zone_sums("Date", "Hour")');
      DB::statement('CREATE INDEX flux30_zone_sums_date_hour_Observation_Zone ON flux30_zone_sums("Date", "Hour","Observation_Zone")');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('flux30_zone_sums', function (Blueprint $table) {
      switch (env('DB_CONNECTION')) {
        case 'pgsql':
          DB::statement('DROP INDEX flux30_zone_sums_date_hour');
          DB::statement('DROP INDEX flux30_zone_sums_date_hour_Observation_Zone');
          break;
        default:
          DB::statement('DROP INDEX flux30_zone_sums_date_hour ON flux30_zone_sums');
          DB::statement('DROP INDEX flux30_zone_sums_date_hour_Observation_Zone ON flux30_zone_sums');
          break;
      }
    });
  }
}
