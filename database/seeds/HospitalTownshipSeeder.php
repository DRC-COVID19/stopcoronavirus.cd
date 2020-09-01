<?php

use Illuminate\Database\Seeder;
use App\Hospital ;

class HospitalTownshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i=1; $i < 13 ; $i++) {
          $hospital = Hospital::find($i) ;
          if($i==1 || $i==2){
            $hospital->township()->associate(21) ;
          }
          else if($i==3){
            $hospital->township()->associate(18) ;
          }
          else if($i==4){
            $hospital->township()->associate(12) ;
          }
          else if($i==5){
            $hospital->township()->associate(11) ;
          }
          else if($i==6){
            $hospital->township()->associate(13) ;
          }
          else if($i==7){
            $hospital->township()->associate(8) ;
          }
          else if($i==8 || $i==12){
            $hospital->township()->associate(4) ;
          }
          else if($i==9){
            $hospital->township()->associate(6) ;
          }
          else if($i==10){
            $hospital->township()->associate(23) ;
          }
          else if($i==11){
            $hospital->township()->associate(19) ;
          }
          $hospital->save() ;
        }
    }
}
