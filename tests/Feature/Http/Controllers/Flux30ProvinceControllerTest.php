<?php

namespace Tests\Feature\Http\Controllers;

use App\Administrator;
use App\Flux30Province;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\Data\Flux30Data;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class Flux30ProvinceControllerTest extends TestCase
{
  use Flux30Data;
  private $header;
  // use RefreshDatabase;
  // use DatabaseMigrations;
  protected function setUp(): void
  {
    parent::setUp();
    // $this->refreshDatabase();
    Flux30Province::insert($this->data);
    $user = factory(Administrator::class)->create();
    $token = JWTAuth::fromUser($user);
    // $this->refreshApplication();

    $this->header = [
      'Authorization' => 'Bearer ' . $token,
      "accept" => "application/json"
    ];
  }
  // /**
  //  * A basic feature test example.
  //  *
  //  * @return void
  //  */
  // public function testFlux30Provinces()
  // {
  //   $query = "preference_start=2020-01-01&preference_end=2020-01-10&observation_start=2020-01-11&observation_end=2020-01-31&fluxGeoGranularity=1&fluxTimeGranularity=1&fluxGeoOptions[]=Kinshasa";
  //   $response = $this->get("/api/dashboard/flux/origin/provinces/m-30?{$query}", $this->header);
  //   $response->dump()->assertStatus(200);
  // }

  public function testFlux30ProvincesDaily()
  {
    $query = "preference_start=2020-01-31&preference_end=2020-01-31&observation_start=2020-02-01&fluxGeoGranularity=1&fluxTimeGranularity=1&fluxGeoOptions[]=Kinshasa";
    $response = $this->get("/api/dashboard/flux/origin/provinces/m-30/daily?{$query}", $this->header);
    $response->dump()->assertStatus(200);
    $data = $response->original;
    $this->assertIsArray($response->original);

    foreach ($data as $key => $value) {
      // $this->assertEquals($value['destination'], "Kinshasa");
      $this->assertArrayHasKey('hour', $value);
      $this->assertArrayHasKey('volume', $value);
      // $this->assertArrayHasKey('date', $value);
      // $this->assertArrayHasKey('day', $value);
      // $this->assertArrayHasKey('origin', $value);
    }
  }

  public function testFlux30ProvincesDailyIn()
  {
    $query = "preference_start=2020-01-31&preference_end=2020-01-31&observation_start=2020-02-01&fluxGeoGranularity=1&fluxTimeGranularity=1&fluxGeoOptions[]=Kinshasa";
    $response = $this->get("/api/dashboard/flux/origin/provinces/m-30/daily-in?{$query}", $this->header);
    $response->dump()->assertStatus(200);
    $data = $response->original;
    $this->assertIsArray($response->original);

    foreach ($response['references'] as $key => $value) {
      $this->assertEquals($value['destination'], "Kinshasa");
      $this->assertArrayHasKey('hour', $value);
      $this->assertArrayHasKey('volume', $value);
      $this->assertArrayHasKey('date', $value);
      $this->assertArrayHasKey('day', $value);
      $this->assertArrayHasKey('origin', $value);
    }

    foreach ($response['observations'] as $key => $value) {
      $this->assertEquals($value['destination'], "Kinshasa");
      $this->assertArrayHasKey('hour', $value);
      $this->assertArrayHasKey('volume', $value);
      $this->assertArrayHasKey('date', $value);
      $this->assertArrayHasKey('day', $value);
      $this->assertArrayHasKey('origin', $value);
    }
  }

  public function testFlux30ProvincesDailyOut()
  {
    $query = "preference_start=2020-01-31&preference_end=2020-01-31&observation_start=2020-02-01&fluxGeoGranularity=1&fluxTimeGranularity=1&fluxGeoOptions[]=Kinshasa";
    $response = $this->get("/api/dashboard/flux/origin/provinces/m-30/daily-out?{$query}", $this->header);
    $response->assertStatus(200);
    $data = $response->original;
    $this->assertIsArray($response->original);

    foreach ($response['references'] as $key => $value) {
      $this->assertEquals($value['origin'], "Kinshasa");
      $this->assertArrayHasKey('hour', $value);
      $this->assertArrayHasKey('volume', $value);
      $this->assertArrayHasKey('date', $value);
      $this->assertArrayHasKey('day', $value);
      $this->assertArrayHasKey('origin', $value);
    }

    foreach ($response['observations'] as $key => $value) {
      $this->assertEquals($value['origin'], "Kinshasa");
      $this->assertArrayHasKey('hour', $value);
      $this->assertArrayHasKey('volume', $value);
      $this->assertArrayHasKey('date', $value);
      $this->assertArrayHasKey('day', $value);
      $this->assertArrayHasKey('origin', $value);
    }
  }
}
