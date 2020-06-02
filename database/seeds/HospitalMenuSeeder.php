<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HospitalMenuSeeder extends Seeder
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
                'order' => 2,
                'title' => 'Hopital',
                'icon' => 'fa-map',
                'uri' => 'hospitals',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Hopital-situations',
                'icon' => 'fa-map',
                'uri' => 'hospital-situations',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }
}
