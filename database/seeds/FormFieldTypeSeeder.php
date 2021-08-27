<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormFieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form_field_types')->truncate();
        DB::table('form_field_types')->insert([
            [
                'name'=>'string'
            ],
            [
                'name'=>'integer'
            ],
            [
                'name'=>'float'
            ],
            [
                'name'=>'boolean'
            ],

        ]);
    }
}
