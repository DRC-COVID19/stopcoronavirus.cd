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

        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '1'
        ]);
        // Facteurs de gravité mineurs Fièvre > ou = 39°C
        // Facteurs de gravité majeurs Fièvre <= 35,4°C
        $response = $this->call("post", '/self-test', [
            'step_value' => null,
            'current_step' => '2'
        ]);

        //Ces derniers jours, avez-vous une toux ou une augmentation de votre toux habituelle ?
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '3'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '4'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '5'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '6'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '7'
        ]);
        //Facteurs de gravité mineurs  Fatigue : alitement > 50%
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '8'
        ]);

        //Facteurs de gravité majeurs Difficultés importantes pour s’alimenter ou boire depuis plus de 24h 
        $response = $this->call("post", '/self-test', [
            'step_value' => '1',
            'current_step' => '9'
        ]);

         //Facteurs de gravité majeurs Gêne respiratoire
         $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '10'
        ]);
       
        //Facteur pronostique
        //Old
        $response = $this->call("post", '/self-test', [
            'step_value' => '55',
            'current_step' => '11'
        ]);

        //Taille
        $response = $this->call("post", '/self-test', [
            'step_value' => '169',
            'current_step' => '12'
        ]);
        //Poids
        $response = $this->call("post", '/self-test', [
            'step_value' => '60',
            'current_step' => '13'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '14'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '2',
            'current_step' => '15'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '16'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '17'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '18'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '19'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '20'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '21'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '22'
        ]);
        $response = $this->call("post", '/self-test', [
            'town' => '0',
            'township'=>null,
            'province'=>'Kinshasa',
            'other_town'=>'kin',
            'current_step' => '23'
        ]);
        $view = $response->original;
        $response->assertStatus(200);
        echo "Test1: ";
        dump($view['resultat']);
    }
}
