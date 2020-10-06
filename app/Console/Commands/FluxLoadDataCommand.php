<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use PDO;

class FluxLoadDataCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'flux30:load';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Command description';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    try {
      $this->output->title("Starting import");
      $pdo = DB::connection()->getpdo();
      $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
      $pdo->setAttribute(PDO::MYSQL_ATTR_LOCAL_INFILE, true);
      DB::beginTransaction();
      for ($i = 1; $i < 30; $i++) {
        $this->output->title("Starting import {$i}");
        $index = $i;
        if ($i <= 9) {
          $index = "0{$i}";
        }

        $rowCount = $pdo->exec(
          "LOAD DATA INFILE 'minutes/Flux_30min_2020-06-{$index}.csv' INTO TABLE `covid_19`.`flux30_zones` CHARACTER SET utf8 FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 LINES (`Date`, `Hour`, `Day_type`, `Origin`, `Destination`, `Immobility`, `Home_Category`, `Activity_Category`, `Observation_Zone`, `Mode`, `Volume`);"
        );
        $this->output->success("Import successful {$i} {$rowCount}");
      }
      DB::commit();
    } catch (\Throwable $th) {
      $this->error($th->getMessage(), 1);
      DB::rollback();
    }
  }
}
