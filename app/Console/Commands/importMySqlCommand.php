<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class importMySqlCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'mysql:import {--file=}';

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
    $fileName = $this->option('file');
    $file = storage_path("app/mysql/{$fileName}.sql");
    $this->output->title("Starting import {$fileName}");
    $check = DB::unprepared(file_get_contents($file));
    if ($check) {
      $this->output->success("Import successful {$fileName}");
    } else {
      $this->output->error("Import successful {$fileName}");
    }
  }
}
