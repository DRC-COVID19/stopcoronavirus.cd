<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->delete();
        DB::table('provinces')->insert([
            [
                'id'=>1,
                'name' => 'Bas-Uele',
                'longitude'=>'24.9042208',
                'latitude'=>'3.9901009'
            ],
            [
                'id'=>2,
                'name' => 'Equateur',
                'longitude'=>'24.9042208',
                'latitude'=>'3.9901009'
            ],
            [
                'id'=>3,
                'name' => 'Haut-Katanga',
                'longitude'=>'27.5495846',
                'latitude'=>'-10.4102075'
            ],
            [
                'id'=>4,
                'name' => 'Haut-Lomami',
                'longitude'=>'24.9042208',
                'latitude'=>'-7.705275199999998'
            ],
            [
                'id'=>5,
                'name' => 'Haut-Uele',
                'longitude'=>'28.299435',
                'latidue'=>'3.5845154'
            ],
            [
                'id'=>6,
                'name' => 'Ituri',
                'longitude'=>'29.966667',
                'latidue'=>'1.85'
            ],
            [
                'id'=>7,
                'name' => 'Kasaï',
                'longitude'=>'20.7122465',
                'latidue'=>'-5.0471979'
            ],
            [
                'id'=>8,
                'name' => 'Kasaï-Central',
                'longitude'=>'22.2384017',
                'latitude'=>'-6.2514921'

            ],
            [
                'id'=>9,
                'name' => 'Kasaï-Oriental',
                'longitude'=>'22.2384017',
                'latitude'=>'-6.2514921'
            ],
            [
                'id'=>10,
                'name' => 'Kinshasa',
                'longitude'=>'15.2662931',
                'latitude'=>'-4.4419311'
            ],
            [
                'id'=>11,
                'name' => 'Kongo-Central',
                'longitude'=>'13.914399',
                'latitude'=>'-5.2365685'
            ],
            [
                'id'=>12,
                'name' => 'Kwango',
                'longitude'=>'17.668887',
                'latitude'=>'-6.4337409'
            ],
            [
                'id'=>13,
                'name' => 'Kwilu',
                'longitude'=>'18.4276047',
                'latitude'=>'-5.1188825'
            ],
            [
                'id'=>14,
                'name' => 'Lomami',
                'longitude'=>'22.72851',
                'latitude'=>'-1.899681'
            ],
            [
                'id'=>15,
                'name' => 'Lualaba',
                'longitude'=>'25.634159',
                'latitude'=>'-10.48087'
            ],
            [
                'id'=>16,
                'name' => 'Maï-Ndombe',
                'longitude'=>'18.4276047',
                'latitude'=>'-2.6357434'
            ],
            [
                'id'=>17,
                'name' => 'Maniema',
                'longitude'=>'28.61903',
                'latitude'=>'-1.167485'
            ],
            [
                'id'=>18,
                'name' => 'Mongala',
                'longitude'=>'21.4752851',
                'latitude'=>'1.9962324'
            ],
            [
                'id'=>19,
                'name' => 'Nord-Kivu',
                'longitude'=>'29.0459927',
                'latitude'=>'-0.7917729'
            ],
            [
                'id'=>20,
                'name' => 'Nord-Ubangi',
                'longitude'=>'21.4752851',
                'latitude'=>'3.7878726'
            ],
            [
                'id'=>21,
                'name' => 'Sankuru',
                'longitude'=>'23.38235449999999',
                'latitude'=>'-2.8437453'
            ],
            [
                'id'=>22,
                'name' => 'Sud-Kivu',
                'longitude'=>'28.299435',
                'latitude'=>'-3.011658'
            ],
            [
                'id'=>23,
                'name' => 'Sud-Ubangi',
                'longitude'=>'19.1880047',
                'latitude'=>'3.2299942'
            ],
            [
                'id'=>24,
                'name' => 'Tanganyika',
                'longitude'=>'27.9249002',
                'latitude'=>'-6.274011799999998'
            ],
            [
                'id'=>25,
                'name' => 'Tshopo',
                'longitude'=>'24.84374',
                'latitude'=>'-10.21105'
            ],
            [
                'id'=>26,
                'name' => 'Tshuapa',
                'longitude'=>'23.0288844',
                'latitude'=>'-0.9903022999999997'
            ]
        ]);
    }
}
