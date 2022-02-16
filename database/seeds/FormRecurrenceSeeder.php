<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormRecurrenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('form_recurrences')->truncate();
        DB::table('form_recurrences')->insert([
            [
                'name'    =>'Tous les jours',
                'slug'    =>'every_day'
            ],
            [
                'name'    => 'Une fois par semaine',
                'slug'    => 'one_time_by_week',
            ],
            [
                'name'    => 'Une fois par mois',
                'slug'    => 'one_time_by_month'
            ],
        ]);
    }
}
