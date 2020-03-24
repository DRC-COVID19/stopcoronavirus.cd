<?php

use Illuminate\Database\Seeder;

class AdminMenuTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('admin_menu')->delete();
        
        \DB::table('admin_menu')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'order' => 1,
                'title' => 'Dashboard',
                'icon' => 'fa-bar-chart',
                'uri' => '/',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 0,
                'order' => 5,
                'title' => 'Admin',
                'icon' => 'fa-tasks',
                'uri' => '',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-03-20 15:45:16',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 2,
                'order' => 6,
                'title' => 'Users',
                'icon' => 'fa-users',
                'uri' => 'auth/users',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-03-20 15:45:16',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 2,
                'order' => 7,
                'title' => 'Roles',
                'icon' => 'fa-user',
                'uri' => 'auth/roles',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-03-20 15:45:16',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 2,
                'order' => 8,
                'title' => 'Permission',
                'icon' => 'fa-ban',
                'uri' => 'auth/permissions',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-03-20 15:45:16',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 2,
                'order' => 9,
                'title' => 'Menu',
                'icon' => 'fa-bars',
                'uri' => 'auth/menu',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-03-20 15:45:16',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 2,
                'order' => 10,
                'title' => 'Operation log',
                'icon' => 'fa-history',
                'uri' => 'auth/logs',
                'permission' => NULL,
                'created_at' => NULL,
                'updated_at' => '2020-03-20 15:45:16',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 0,
                'order' => 2,
                'title' => 'Gestion des contenus',
                'icon' => 'fa-book',
                'uri' => 'posts',
                'permission' => '*',
                'created_at' => '2020-03-20 15:44:10',
                'updated_at' => '2020-03-20 15:45:16',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 0,
                'order' => 3,
                'title' => 'Gestion des alertes',
                'icon' => 'fa-bell-o',
                'uri' => 'alerts',
                'permission' => '*',
                'created_at' => '2020-03-20 15:44:39',
                'updated_at' => '2020-03-20 15:45:30',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 0,
                'order' => 4,
                'title' => 'Gestion des catégories',
                'icon' => 'fa-bars',
                'uri' => 'categories',
                'permission' => '*',
                'created_at' => '2020-03-20 15:45:03',
                'updated_at' => '2020-03-20 15:45:16',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 0,
                'order' => 0,
                'title' => 'Gestion des provinces',
                'icon' => 'fa-bank',
                'uri' => 'provinces',
                'permission' => '*',
                'created_at' => '2020-03-23 13:12:01',
                'updated_at' => '2020-03-23 13:41:28',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 0,
                'order' => 0,
                'title' => 'Gestion des diffusions',
                'icon' => 'fa-bars',
                'uri' => 'sms-diffusions',
                'permission' => '*',
                'created_at' => '2020-03-23 13:12:41',
                'updated_at' => '2020-03-23 13:12:41',
            ),
            11 => 
            array (
                'id' => 13,
                'parent_id' => 0,
                'order' => 0,
                'title' => 'Suivi de cas',
                'icon' => 'fa-bars',
                'uri' => 'pandemic-stats',
                'permission' => '*',
                'created_at' => '2020-03-23 13:12:41',
                'updated_at' => '2020-03-23 13:12:41',
            ),
        ));
        
        
    }
}