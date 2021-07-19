<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Flux24PresenceZonesAddIndex extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('flux24_presence_zones', function (Blueprint $table) {
      $table->index('Date', 'flux24_presence_zones_index_date');
      $table->index('Zone', 'flux24_presence_zones_index_zone');
      DB::statement('CREATE INDEX flux24_presence_zones_date_zone ON flux24_presence_zones(`Date`, `Zone`)');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('flux24_presence_zones', function (Blueprint $table) {
      $table->dropIndex('flux24_presence_zones_index_date');
      $table->dropIndex('flux24_presence_zones_index_zone');
      switch (env('DB_CONNECTION')) {
        case 'pgsql':
          DB::statement('DROP INDEX flux24_presence_zones_date_zone');
          break;
        default:
          DB::statement('DROP INDEX flux24_presence_zones_date_zone ON flux24_presence_zones');
          break;
      }
    });
  }
}
