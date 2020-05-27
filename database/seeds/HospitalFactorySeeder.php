<?php

use App\Hospital;
use App\HospitalSituation;
use Illuminate\Database\Seeder;

class HospitalFactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Hospital::class, 5)->create()->each(function (Hospital $hospital) {
            factory(HospitalSituation::class, 3)
                ->create([
                    'hospital_id' => $hospital->id,
                ]);
        });
    }
}
