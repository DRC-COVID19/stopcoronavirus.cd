<?php

namespace Tests\Feature;

use App\Hospital;
use App\HospitalSituation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashBoardTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        factory(Hospital::class, 1)->create()->each(function (Hospital $hospital) {
            factory(HospitalSituation::class, 3)
                ->create([
                    'hospital_id' => $hospital->id,
                ]);
        });
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/api/dashboard/hospitals');
        $response->dump()->assertStatus(200);
    }
}
