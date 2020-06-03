<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('posts')->truncate();

        DB::table('posts')->insert(array(
            0 =>
            array(
                'id' => 1,
                'category_id' => 1,
                'created_at' => '2020-03-20 15:57:31',
                'updated_at' => '2020-03-20 20:42:23',
                'image_path' => null,
                'width' => 4,
                'order' => 1,
            ),
            1 =>
            array(
                'id' => 2,
                'category_id' => 1,
                'created_at' => '2020-03-20 15:58:59',
                'updated_at' => '2020-03-20 20:42:48',
                'image_path' => null,
                'width' => 4,
                'order' => 2,
            ),
            2 =>
            array(
                'id' => 3,
                'category_id' => 1,
                'created_at' => '2020-03-20 15:59:26',
                'updated_at' => '2020-03-20 20:43:06',
                'image_path' => null,
                'width' => 4,
                'order' => 3,
            ),
            3 =>
            array(
                'id' => 4,
                'category_id' => 2,
                'created_at' => '2020-03-20 18:45:26',
                'updated_at' => '2020-03-23 16:25:19',
                'image_path' => NULL,
                'width' => 4,
                'order' => 1,
            ),
            4 =>
            array(
                'id' => 5,
                'category_id' => 3,
                'created_at' => '2020-03-20 18:53:44',
                'updated_at' => '2020-03-20 19:00:30',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            5 =>
            array(
                'id' => 6,
                'category_id' => 3,
                'created_at' => '2020-03-20 18:54:33',
                'updated_at' => '2020-03-20 18:54:33',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            6 =>
            array(
                'id' => 7,
                'category_id' => 3,
                'created_at' => '2020-03-20 18:55:09',
                'updated_at' => '2020-03-20 19:00:48',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            7 =>
            array(
                'id' => 8,
                'category_id' => 1,
                'created_at' => '2020-03-20 19:45:27',
                'updated_at' => '2020-03-20 19:45:27',
                'image_path' => NULL,
                'width' => 4,
                'order' => 4,
            ),
            8 =>
            array(
                'id' => 9,
                'category_id' => 1,
                'created_at' => '2020-03-20 19:46:00',
                'updated_at' => '2020-03-20 19:46:00',
                'image_path' => NULL,
                'width' => 4,
                'order' => 5,
            ),
            9 =>
            array(
                'id' => 10,
                'category_id' => 1,
                'created_at' => '2020-03-20 19:47:02',
                'updated_at' => '2020-03-20 19:47:02',
                'image_path' => NULL,
                'width' => 12,
                'order' => 6,
            ),
            12 =>
            array(
                'id' => 13,
                'category_id' => 3,
                'created_at' => '2020-03-20 20:05:15',
                'updated_at' => '2020-03-20 20:05:15',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            13 =>
            array(
                'id' => 14,
                 'category_id' => 3,
                'created_at' => '2020-03-20 20:05:48',
                'updated_at' => '2020-03-20 20:05:48',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            14 =>
            array(
                'id' => 15,
                'category_id' => 3,
                'created_at' => '2020-03-20 20:06:33',
                'updated_at' => '2020-03-20 20:06:33',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            15 =>
            array(
                'id' => 16,
               'category_id' => 3,
                'created_at' => '2020-03-20 20:07:35',
                'updated_at' => '2020-03-20 20:07:35',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            16 =>
            array(
                'id' => 17,
                'category_id' => 3,
                'created_at' => '2020-03-20 20:08:04',
                'updated_at' => '2020-03-20 20:08:04',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            17 =>
            array(
                'id' => 18,
                'category_id' => 3,
                'created_at' => '2020-03-20 20:08:36',
                'updated_at' => '2020-03-20 20:08:36',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            18 =>
            array(
                'id' => 19,
               'category_id' => 3,
                'created_at' => '2020-03-20 20:09:05',
                'updated_at' => '2020-03-20 20:09:05',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            19 =>
            array(
                'id' => 20,
                'category_id' => 3,
                'created_at' => '2020-03-20 20:09:37',
                'updated_at' => '2020-03-20 20:09:37',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            20 =>
            array(
                'id' => 21,
               'category_id' => 3,
                'created_at' => '2020-03-20 20:10:04',
                'updated_at' => '2020-03-20 20:10:04',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            21 =>
            array(
                'id' => 22,
                'category_id' => 3,
                'created_at' => '2020-03-20 20:10:30',
                'updated_at' => '2020-03-20 20:10:30',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            22 =>
            array(
                'id' => 23,
                'category_id' => 3,
                'created_at' => '2020-03-20 20:11:01',
                'updated_at' => '2020-03-20 20:11:01',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
            23 =>
            array(
                'id' => 24,
                'category_id' => 3,
                'created_at' => '2020-03-20 20:11:30',
                'updated_at' => '2020-03-20 20:11:30',
                'image_path' => NULL,
                'width' => 4,
                'order' => 0,
            ),
        ));
    }
}
