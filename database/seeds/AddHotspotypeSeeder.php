<?php

use App\FluxHotSpot;
use Illuminate\Database\Seeder;

class AddHotspotypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $hotspots = [
      0 => [
        'type' => 'BureauAdmin',
        'name' => 'ONATRA',
      ],
      1 => [
        'type' => 'Eglises',
        'name' => 'Paroisse Sacre Coeur',
      ],
      2 => [
        'type' => 'Commerces',
        'name' => 'INA et ORCA',
      ],
      3 => [
        'type' => 'Supermarche',
        'name' => 'Arret Station Centre Superieur',
      ],
      4 => [
        'type' => 'Marché',
        'name' => 'Marché BAYAKA',
      ],
      5 => [
        'type' => 'Hotels',
        'name' => 'Hotel Memling',
      ],
      6 => [
        'type' => 'Hotels',
        'name' => 'Place de la gare centrale',
      ],
      7 => [
        'type' => 'Eglises',
        'name' => 'Eglise Catholique Divin Maître',
      ],
      8 => [
        'type' => 'ArretTransport',
        'name' => 'Arret Bakayaou',
      ],
      9 => [
        'type' => 'Commerces',
        'name' => 'Parc Mont Ngaliema',
      ],
      10 => [
        'type' => 'Eglises',
        'name' => 'Eglise des assemblées de dieu',
      ],
      11 => [
        'type' => 'Restaurants',
        'name' => 'Dvin',
      ],
      12 => [
        'type' => 'BureauAdmin',
        'name' => 'Rond Point Forescom',
      ],
      13 => [
        'type' => 'ArretTransport',
        'name' => 'Huillerie',
      ],
      14 => [
        'type' => 'BureauAdmin',
        'name' => 'Poste',
      ],
      15 => [
        'type' => 'Supermarche',
        'name' => 'SONAS',
      ],
      16 => [
        'type' => 'BureauAdmin',
        'name' => 'Immeuble CNSS',
      ],
      17 => [
        'type' => 'Marché',
        'name' => 'Marché de Mbanza Lemba',
      ],
      18 => [
        'type' => 'Commerces',
        'name' => 'Le premier Shopping Mall',
      ],
      19 => [
        'type' => 'Hotels',
        'name' => 'Hotel Sultani',
      ],
      20 => [
        'type' => 'Restaurants',
        'name' => 'Le cerlce gourmand',
      ],
      21 => [
        'type' => 'Eglises',
        'name' => 'Eglise Notre Dame de Fatima',
      ],
      22 => [
        'type' => 'ArretTransport',
        'name' => 'Avenue du Commerce et Kasa vubu',
      ],
      23 => [
        'type' => 'Eglises',
        'name' => 'Mosqué Centrale Usoke',
      ],
      24 => [
        'type' => 'ArretTransport',
        'name' => 'ASSANEF',
      ],
      25 => [
        'type' => 'Commerces',
        'name' => 'Hall de la Gombe',
      ],
      26 => [
        'type' => 'Eglises',
        'name' => 'Mosqué Bon Marche',
      ],
      27 => [
        'type' => 'Supermarche',
        'name' => 'Paroisse Saint Eloi',
      ],
      28 => [
        'type' => 'Eglises',
        'name' => 'Eglise Francophone Ecole de Tyrannus',
      ],
      29 => [
        'type' => 'Eglises',
        'name' => 'Eglise Saint Paul',
      ],
      30 => [
        'type' => 'Eglises',
        'name' => 'Eglise locale Cbfc Itaga',
      ],
      31 => [
        'type' => 'Marché',
        'name' => 'Marché central',
      ],
      32 => [
        'type' => 'Eglises',
        'name' => 'Mosqué Kingabwa',
      ],
      33 => [
        'type' => 'Eglises',
        'name' => 'le pain de vie',
      ],
      34 => [
        'type' => 'Eglises',
        'name' => 'Centre Evangelique Emmanuel Langa-langa',
      ],
      35 => [
        'type' => 'Eglises',
        'name' => 'Centre d\'Evangelisation Peniel CEPE',
      ],
      36 => [
        'type' => 'Eglises',
        'name' => 'Ejcev Nouvelle Alliance Bima',
      ],
      37 => [
        'type' => 'Eglises',
        'name' => 'Paroisse saint François-Xavier',
      ],
      38 => [
        'type' => 'Commerces',
        'name' => 'FIKIN',
      ],
      39 => [
        'type' => 'Eglises',
        'name' => 'Paroisse Notre-Dame d\'Afrique',
      ],
      40 => [
        'type' => 'Eglises',
        'name' => 'Ministere combat spirituel',
      ],
      41 => [
        'type' => 'Eglises',
        'name' => 'Eglise Kimbanguiste',
      ],
      42 => [
        'type' => 'ArretTransport',
        'name' => 'Croissement Kianza et Universite',
      ],
      43 => [
        'type' => 'Commerces',
        'name' => 'Arret Stade Velodrome',
      ],
      44 => [
        'type' => 'Eglises',
        'name' => 'ECC/CEC/BUMBU',
      ],
      45 => [
        'type' => 'Marché',
        'name' => 'Wenze Muselu/Gambela',
      ],
      46 => [
        'type' => 'Marché',
        'name' => 'Marché selembao',
      ],
      47 => [
        'type' => 'Marché',
        'name' => 'MArché Delvaux',
      ],
      48 => [
        'type' => 'Restaurants',
        'name' => 'Salle de fete de la Rotonde Binza',
      ],
      49 => [
        'type' => 'Commerces',
        'name' => 'Immeuble Cosmos',
      ],
      50 => [
        'type' => 'ArretTransport',
        'name' => 'DGC barre',
      ],
      51 => [
        'type' => 'Restaurants',
        'name' => 'Food Market Macampagne',
      ],
      52 => [
        'type' => 'ArretTransport',
        'name' => 'Arret Station Macampagne (ML)',
      ],
      53 => [
        'type' => 'Eglises',
        'name' => 'eglise protestante de lemba',
      ],
      54 => [
        'type' => 'Hopitaux',
        'name' => 'Hopital general de Kintambo',
      ],
      55 => [
        'type' => 'Restaurants',
        'name' => 'O\'Poeta',
      ],
      56 => [
        'type' => 'Restaurants',
        'name' => 'Gabriella',
      ],
      57 => [
        'type' => 'Supermarche',
        'name' => 'Shoprite',
      ],
      58 => [
        'type' => 'Restaurants',
        'name' => 'ROND POINT SAFRICAS',
      ],
      59 => [
        'type' => 'ArretTransport',
        'name' => 'Arret Socimat',
      ],
      60 => [
        'type' => 'Supermarche',
        'name' => 'HOTEL DU GOUVERNEMENT',
      ],
      61 => [
        'type' => 'Marché',
        'name' => 'Matadi Kibala',
      ],
      62 => [
        'type' => 'BureauAdmin',
        'name' => 'Ministere des affaires etrangeres',
      ],
      63 => [
        'type' => 'Commerces',
        'name' => 'Shark Club',
      ],
      64 => [
        'type' => 'BureauAdmin',
        'name' => 'BATETELA',
      ],
      65 => [
        'type' => 'Restaurants',
        'name' => 'Mimoza plaza',
      ],
      66 => [
        'type' => 'Cimetiere',
        'name' => 'Cimetiere sans fil',
      ],
      67 => [
        'type' => 'ArretTransport',
        'name' => 'Arret Centre hospitalier de Kintambo',
      ],
      68 => [
        'type' => 'BureauAdmin',
        'name' => 'TASOK',
      ],
      69 => [
        'type' => 'Marché',
        'name' => 'Marché Mangobo',
      ],
      70 => [
        'type' => 'Supermarche',
        'name' => 'Carrigres',
      ],
      71 => [
        'type' => 'Commerces',
        'name' => 'Mbudi Nature',
      ],
      72 => [
        'type' => 'Cimetiere',
        'name' => 'Kinsuka',
      ],
      73 => [
        'type' => 'ArretTransport',
        'name' => 'Binza Arret Maternite',
      ],
      74 => [
        'type' => 'Supermarche',
        'name' => 'Peloustore KIVU',
      ],
      75 => [
        'type' => 'Marché',
        'name' => 'Marché Mbika',
      ],
      76 => [
        'type' => 'ArretTransport',
        'name' => 'UPN Djelo',
      ],
      77 => [
        'type' => 'Cimetiere',
        'name' => 'Cimetiere Kimbanseke',
      ],
      78 => [
        'type' => 'Cimetiere',
        'name' => 'Cimetiere Mingadi',
      ],
      79 => [
        'type' => 'Cimetiere',
        'name' => 'Benseke Nouvelle Cite',
      ],
      80 => [
        'type' => 'Cimetiere',
        'name' => 'Cimetiere Ndjili Brasserie',
      ],
      81 => [
        'type' => 'ArretTransport',
        'name' => 'Rond Point Ngaba',
      ],
      82 => [
        'type' => 'ArretTransport',
        'name' => 'Place sainte therese',
      ],
      83 => [
        'type' => 'Eglises',
        'name' => 'Baruti Tabernacle',
      ],
      84 => [
        'type' => 'Eglises',
        'name' => 'CE TRINITE',
      ],
      85 => [
        'type' => 'ArretTransport',
        'name' => 'Lemba Terminus',
      ],
      86 => [
        'type' => 'ArretTransport',
        'name' => 'Pont Matete',
      ],
      87 => [
        'type' => 'Marché',
        'name' => 'Marché Matete',
      ],
      88 => [
        'type' => 'ArretTransport',
        'name' => 'Marché de la liberté',
      ],
      89 => [
        'type' => 'Hopitaux',
        'name' => 'Hopital Biamba Marie Mutombo',
      ],
      90 => [
        'type' => 'ArretTransport',
        'name' => 'Quartier 1 (croissement Boulevard Lumumba)',
      ],
      91 => [
        'type' => 'Cimetiere',
        'name' => 'Kinkole',
      ],
      92 => [
        'type' => 'Cimetiere',
        'name' => 'Necropole entre ciel et terre',
      ],
      93 => [
        'type' => 'Cimetiere',
        'name' => 'Necropole entre ciel et terre',
      ],
      94 => [
        'type' => 'Marché',
        'name' => 'Maché De Kadi',
      ],
      95 => [
        'type' => 'BureauAdmin',
        'name' => 'INBTP',
      ],
      96 => [
        'type' => 'Hotels',
        'name' => 'Hotel du Fleuve',
      ],
      97 => [
        'type' => 'Restaurants',
        'name' => 'La voix du fleuve',
      ],
      98 => [
        'type' => 'Cimetiere',
        'name' => 'Cimetiere Kintambo',
      ],
      99 => [
        'type' => 'ArretTransport',
        'name' => 'Arret moulard',
      ],
      100 => [
        'type' => 'Hopitaux',
        'name' => 'Place Commercial de limete(7e rue)',
      ],
      101 => [
        'type' => 'Aéroport',
        'name' => 'Aéroport Ndolo',
      ],
      102 => [
        'type' => 'Aéroport',
        'name' => 'Aéroport Ndjili',
      ],
    ];

    foreach ($hotspots as $value) {
      $hotspot = FluxHotSpot::where('name', $value['name'])->first();
      if ($hotspot) {
        $hotspot->type = $value['type'];
        $hotspot->save();
      }
    }
  }
}
