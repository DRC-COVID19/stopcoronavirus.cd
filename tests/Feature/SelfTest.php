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
        session()->remove('test');

        // Facteurs de gravité mineurs Fièvre 2 ou 4
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '5',
            'current_step' => '1'
        ]);
        
        //Ces derniers jours, avez-vous une toux ou une augmentation de votre toux habituelle ?
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '2'
        ]);

        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '3'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '4'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '5'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '6'
        ]);

         //Facteurs de gravité mineurs  Fatigue : alitement > 50%  1
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '1',
            'current_step' => '7'
        ]);
       
         //Facteurs de gravité majeurs Difficultés importantes pour s’alimenter ou boire depuis plus de 24h 
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '8'
        ]);
       
        //Facteurs de gravité majeurs Gêne respiratoire
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '9'
        ]);

        //Facteur pronostique
        //Age
         $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '65',
            'current_step' => '10'
        ]);
       
        //Taille
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '169',
            'current_step' => '11'
        ]);

         //Poids
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '60',
            'current_step' => '12'
        ]);
       
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '13'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '14'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '15'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '16'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '17'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '18'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '19'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '20'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'step_value' => '0',
            'current_step' => '21'
        ]);
        $response = $this->call("post", 'orientation-medicale-test', [
            'town' => '0',
            'township'=>null,
            'province'=>'Kinshasa',
            'other_town'=>'kin',
            'current_step' => '22'
        ]);
        $view = $response->original;
        $response->assertStatus(200);
        echo "Test1: ";
        dump($view['resultat']);
    }
}
