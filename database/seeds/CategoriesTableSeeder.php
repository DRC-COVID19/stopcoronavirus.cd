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
            1 => 
            array (
                'id' => 2,
                'name' => 'Mesures prises par le Gouvernement',
                'icon' => NULL,
                'slug' => 'mesures-prises-par-le-gouvernement',
                'created_at' => '2020-03-20 16:07:44',
                'updated_at' => '2020-03-20 16:07:44',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'En finir avec les idées reçues',
                'icon' => NULL,
                'slug' => 'en-finir-avec-les-idees-recues',
                'created_at' => '2020-03-20 16:07:58',
                'updated_at' => '2020-03-20 16:07:58',
            ),
        ));
        
        
    }
}