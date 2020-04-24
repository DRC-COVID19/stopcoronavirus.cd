<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResetDiagnosticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diagnostics')->delete();
    }
}
