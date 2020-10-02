<?php

namespace Tests\Feature\Http\Controllers;

use App\Administrator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class Flux30ZoneSumControllerTest extends TestCase
{

  private $header;
  // use RefreshDatabase;
  // use DatabaseMigrations;
  protected function setUp(): void
  {
    parent::setUp();
    // $this->refreshDatabase();
    // Flux30Province::insert($this->data);
    // Flux30Province::insert($this->data2);
    $user = factory(Administrator::class)->create();
    $token = JWTAuth::fromUser($user);
    // $this->refreshApplication();

    $this->header = [
      'Authorization' => 'Bearer ' . $token,
      "accept" => "application/json"
    ];
  }

  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function testGetHotspotMaps()
  {
    $query = "fluxGeoGranularity=1&fluxTimeGranularity=1&fluxGeoOptions[]=Kinshasa&preference_start=2020-02-18&preference_end=2020-03-18&observation_start=2020-03-19&observation_end=2020-03-28&time_start=06:00&time_end=23:30";
    $response = $this->get("/api/dashboard/flux/hotspots/maps?{$query}",$this->header);
    $response->dump()->assertStatus(200);
  }
}
