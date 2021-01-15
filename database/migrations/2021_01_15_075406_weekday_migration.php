<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WeekdayMigration extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    //we create function Weekday for pgsql

    if (env('DB_CONNECTION') == 'pgsql') {
      echo env('DB_CONNECTION') ;
      DB::statement("CREATE OR REPLACE FUNCTION WEEKDAY(date) RETURNS double precision LANGUAGE 'sql' COST 100 VOLATILE AS $$ SELECT EXTRACT(isodow FROM cast($1 as date))-1; $$;");

    }
    // if (env('APP_ENV') == 'testing') {
    //   function WEEKDAY($string)
    //   {
    //     return md5($string);
    //   }
    //   $db=DB::connection()->getPdo();
    //   $db->createFunction('WEEKDAY', 'WEEKDAY');
    // }

  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    if (env('DB_CONNECTION') == 'pgsql') {
      DB::statement('DROP FUNCTION WEEKDAY');
    }
  }
}
