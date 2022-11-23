<?php

namespace App\Console\Commands;

use App\Imports\Flux24ProvinceImport;
use App\Imports\FluxImport;
use App\Imports\FluxPresenceProvinceImport;
use App\Imports\FluxPresenceZoneImport;
use Illuminate\Console\Command;

class ImportExcel extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'flux:import {--type=} {--file=} {--size=} {--start=1}';

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
    $type = $this->option('type');
    $fileName = $this->option('file');
    $size = $this->option('size');
    $start = $this->option('start');
    switch ($type) {
      case 'pp':
        for ($i = $start; $i <= $size; $i++) {
          $file = "{$fileName}-{$i}.csv";
          $this->output->title("Starting import {$file}");
          (new FluxPresenceProvinceImport())
            ->withOutput($this->output)
            ->import(
              storage_path("app/flux/$file"),
              null,
              \Maatwebsite\Excel\Excel::CSV
            );
          $this->output->success("Import successful {$file}");
        }
        break;
      case 'pz':
        for ($i = $start; $i <= $size; $i++) {
          $file = "{$fileName}-{$i}.csv";
          $this->output->title("Starting import {$file}");
          (new FluxPresenceZoneImport())
            ->withOutput($this->output)
            ->import(
              storage_path("app/flux/$file"),
              null,
              \Maatwebsite\Excel\Excel::CSV
            );
          $this->output->success("Import successful {$file}");
        }
        break;
      case 'p':
        for ($i = $start; $i <= $size; $i++) {
          $file = "{$fileName}-{$i}.csv";
          $this->output->title("Starting import {$file}");
          (new Flux24ProvinceImport())
            ->withOutput($this->output)
            ->import(
              storage_path("app/flux/$file"),
              null,
              \Maatwebsite\Excel\Excel::CSV
            );
          $this->output->success("Import successful {$file}");
        }
        break;
      case 'z':
        for ($i = $start; $i <= $size; $i++) {
          $file = "{$fileName}-{$i}.csv";
          $this->output->title("Starting import {$file}");
          (new FluxImport())
            ->withOutput($this->output)
            ->import(
              storage_path("app/flux/$file"),
              null,
              \Maatwebsite\Excel\Excel::CSV
            );
          $this->output->success("Import successful {$file}");
        }
        break;
      default:
        # code...
        break;
    }
  }
}
