<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SelfTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
       $this->code([
           5, //Fievre
           0, //Toux
           0, // Ces derniers jours, avez-vous noté une forte diminution ou perte de votre goût ou de votre odorat ?
           0, // Douleurs
           0, // Ces dernières 24 heures, avez-vous de la diarrhée ? Avec au moins 3 selles molles.
           0, // Ces derniers jours, avez-vous une fatigue inhabituelle ?
           0, // Cette fatigue vous oblige-t-elle à vous reposer plus de la moitié de la journée ?
           0, // Êtes vous dans l'impossibilité de vous alimenter ou de boire DEPUIS 24 HEURES OU PLUS ?
           0, // Dans les dernières 24 heures, avez-vous noté un manque de souffle INHABITUEL lorsque vous parlez ou faites un petit effort ?
           50, // Quel est votre âge ? Ceci, afin de calculer un facteur de risque spécifique.
           169, // Quel est votre taille ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.
           62, // Quel est votre poids ? Afin de calculer l’indice de masse corporelle qui est un facteur influençant le risque de complications de l’infection.
           0, // Avez-vous de l’hypertension artérielle mal équilibrée ? Ou avez-vous une maladie cardiaque ou vasculaire ? Ou prenez vous un traitement à visée cardiologique ?
           0, // Êtes-vous diabétique ?
           0, // Avez-vous ou avez-vous eu un cancer ces trois dernières années ?
           0, // Avez-vous une maladie respiratoire ? Ou êtes-vous suivi par un pneumologue ?
           0, // Avez-vous une insuffisance rénale chronique dialysée ?
           0,// Avez-vous une maladie chronique du foie ?
           0, // Êtes-vous enceinte ?
           0, // Avez-vous une maladie connue pour diminuer vos défenses immunitaires ?
           0,// Prenez-vous un traitement immunosuppresseur ? C’est un traitement qui diminue vos défenses contre les infections. Voici quelques exemples : corticoïdes, méthotrexate, ciclosporine, tacrolimus, azathioprine, cyclophosphamide (liste non exhaustive).
           0, //Town
           0, // Township
           0, // province
       ]);
    }

    public function code(array $input)
    {
        session()->remove('test');

        // Facteurs de gravité mineurs Fièvre 2 ou 4
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[0],
            'current_step' => '1'
        ]);
        
        //Ces derniers jours, avez-vous une toux ou une augmentation de votre toux habituelle ?
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[1],
            'current_step' => '2'
        ]);

        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[2],
            'current_step' => '3'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[3],
            'current_step' => '4'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[4],
            'current_step' => '5'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[5],
            'current_step' => '6'
        ]);

         //Facteurs de gravité mineurs  Fatigue : alitement > 50%  1
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[6],
            'current_step' => '7'
        ]);
       
         //Facteurs de gravité majeurs Difficultés importantes pour s’alimenter ou boire depuis plus de 24h 
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[7],
            'current_step' => '8'
        ]);
       
        //Facteurs de gravité majeurs Gêne respiratoire
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[8],
            'current_step' => '9'
        ]);

        //Facteur pronostique
        //Age
         $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[9],
            'current_step' => '10'
        ]);
       
        //Taille
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[10],
            'current_step' => '11'
        ]);

         //Poids
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[11],
            'current_step' => '12'
        ]);
       
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[12],
            'current_step' => '13'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[13],
            'current_step' => '14'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[14],
            'current_step' => '15'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[15],
            'current_step' => '16'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[16],
            'current_step' => '17'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[17],
            'current_step' => '18'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[18],
            'current_step' => '19'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[19],
            'current_step' => '20'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => $input[20],
            'current_step' => '21'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'town' => $input[21],
            'township'=>$input[22],
            'province'=>$input[23],
            'current_step' => '22'
        ]);
        $view = $response->original;
        $response->assertStatus(200);
        echo "Test1: ";
        dump($view['resultat']);
    }
}
