<?php

namespace App\Console\Commands;

use App\Imports\HealthZoneImport;
use Illuminate\Console\Command;

class HealthZoneImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:healthZone {--file=}';

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
        $file = "{$fileName}.csv";
        $this->output->title("Starting import {$file}");
        (new HealthZoneImport)->withOutput($this->output)->import(storage_path("app/health_zone/$file"), null, \Maatwebsite\Excel\Excel::CSV);
        $this->output->success("Import successful {$file}");
    }
}
