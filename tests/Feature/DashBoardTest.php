<?php

namespace Tests\Feature;

use App\Hospital;
use App\HospitalSituation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashBoardTest extends TestCase
{
    // use RefreshDatabase;
    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     factory(Hospital::class, 1)->create()->each(function (Hospital $hospital) {
    //         factory(HospitalSituation::class, 3)
    //             ->create([
    //                 'hospital_id' => $hospital->id,
    //             ]);
    //     });
    // }

      public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function testExample()
    // {
    //     $response = $this->get('/api/dashboard/hospitals');
    //     $response->dump()->assertStatus(200);
    // }

    // public function testSondage()
    // {
    //     $response = $this->get('/api/dashboard/sondages');
    //     $response->dump()->assertStatus(200);
    // }
}
