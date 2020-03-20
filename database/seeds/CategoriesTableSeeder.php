<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Mesures de protection essentielles contre le nouveau coronavirus',
                'icon' => NULL,
                'slug' => NULL,
                'created_at' => '2020-03-20 15:55:33',
                'updated_at' => '2020-03-20 15:55:33',
            ),
        ));
        
        
    }
}