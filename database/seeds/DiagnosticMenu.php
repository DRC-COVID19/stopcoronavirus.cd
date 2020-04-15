<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiagnosticMenu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Suivi tests diagnostiques',
                'icon' => 'fa-bar-chart',
                'uri' => 'diagnostics',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
    }
}
