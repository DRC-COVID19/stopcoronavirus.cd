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
      'Authorization' => 'Bearer ' . $token
    ];
  }
  /**
   * A basic feature test example.
   *
   * @return void
   */
  public function testExample()
  {
    $query = "?preference_start=2020-02-18&preference_end=2020-03-18&observation_start=2020-03-19&observation_end=2020-06-29&fluxGeoGranularity=1&fluxTimeGranularity=1&fluxGeoOptions[]=Kinshasa";
    $response = $this->get("/api/dashboard/flux/origin/provinces/m-30?{$query}", $this->header);
    $response->dump()->assertStatus(200);
  }
}
