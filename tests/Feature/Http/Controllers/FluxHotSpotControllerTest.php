<?php

namespace Tests\Feature\Http\Controllers;

use App\Administrator;
use App\FluxHotSpot as AppFluxHotSpot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\Feature\Http\Controllers\Data\FluxHotSpotData;
use Tymon\JWTAuth\Facades\JWTAuth;

class FluxHotSpotControllerTest extends TestCase
{
  use FluxHotSpotData;

  protected function setUp(): void
  {
    parent::setUp();
    // $this->refreshDatabase();
    AppFluxHotSpot::insert($this->data);
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
  public function testGetHotSpotList()
  {
    $response = $this->get('/api/dashboard/flux/hotspots/list', $this->header);
    $response->assertStatus(200);
    $data = $response->original;
    $this->assertIsArray($data);
    $this->assertCount(269,$data);
    foreach ($data as $key => $value) {
      $this->assertArrayHasKey('name', $value);
    }
  }
}
