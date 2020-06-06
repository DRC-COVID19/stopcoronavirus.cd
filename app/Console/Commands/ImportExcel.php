<?php

namespace App\Console\Commands;

use App\Imports\FluxImport;
use Illuminate\Console\Command;

class ImportExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flux:import';

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
        for ($i = 1; $i <= 108; $i++) {
            $file="Flux_24h-{$i}.csv";
            $this->output->title("Starting import {$file}");
            (new FluxImport)->withOutput($this->output)->import(storage_path("app/flux/$file"), null, \Maatwebsite\Excel\Excel::CSV);
            $this->output->success("Import successful {$file}");
        }
    }
}
