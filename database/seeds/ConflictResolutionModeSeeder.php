<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConflictResolutionModeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('conflict_resolution_modes')->truncate();
        DB::table('conflict_resolution_modes')->insert([
            [
                'name'    =>'priorité à l\'ancienne soumission',
                'slug'    =>'old_submission'
            ],
            [
                'name'    => 'priorité à la nouvelle soumission',
                'slug'    => 'new_submission',
            ],
            [
                'name'    => 'le dernier à soumettre résout le conflit',
                'slug'    => 'last_submission',
            ],
            [
                'name'    => 'l\'administrateur résout le conflit',
                'slug'    => 'admin_resolution',
            ],
        ]);
    }
}
