<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SelfTest2 extends TestCase
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
            'step_value' => '1',
            'current_step' => '1'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '35',
            'current_step' => '2'
        ]);
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
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '8'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '9'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '10'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '0',
            'current_step' => '11'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '45',
            'current_step' => '12'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '169',
            'current_step' => '13'
        ]);
        $response = $this->call("post", '/self-test', [
            'step_value' => '60',
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
            'step_value' => '0',
            'current_step' => '23'
        ]);
        $view = $response->original;
        $response->assertStatus(200);
        echo "Test2: ";
        dump($view['resultat']);
    }
}
