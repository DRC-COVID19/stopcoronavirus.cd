<?php

namespace App\MyTrait;

use Illuminate\Support\Str;

/**
 *
 */
trait GeoCoding
{
  private $townGeocoding = [];

  public function addTownGeoCoding($town, $province)
  {
    try {
      $MAP_BOX_KEY = env('MAP_BOX_KEY');
      $data = [];
      $town = strtoupper($town);
      $province = strtoupper($province);
      $provinceCopy = $province;
      $index = strtoupper(Str::slug($province . '_' . $town, '_'));
      switch ($province) {
        case 'KONGO-CENTRAL':
          $provinceCopy = 'Bas-Congo';
          break;
        case 'NORD-UBANGI':
          $provinceCopy = 'Équateur';
          break;
        case 'KASAï':
        case 'KASAï':
        case 'KASAï-CENTRAL':
        case 'KASAI-CENTRAL':
          $provinceCopy = 'Kasaï-Occidental';
        case 'TSHOPO':
        case 'HAUT-UELE':
          $provinceCopy = 'Orientale';
          break;
        case 'SANKURU':
          $provinceCopy = 'Kasaï-Oriental';
          break;
        default:
          # code...
          break;
      }

      if ($province == $town) {
        $provinceCopy = null;
      }
      $geoCodingFilePath = storage_path('app/townGeocoding.json');
      if (file_exists($geoCodingFilePath)) {
        $jsonString = file_get_contents($geoCodingFilePath);
        $data = json_decode($jsonString, true);
      }
      $client = new \GuzzleHttp\Client();
      $response = $client->request(
        'GET',
        "https://api.mapbox.com/geocoding/v5/mapbox.places/{$town}, {$provinceCopy}.json?access_token={$MAP_BOX_KEY}&country=cd"
      );
      $content = json_decode($response->getBody()->getContents());
      $dataFind = null;
      if ($content && isset($content->features[0])) {
        if (count($content->features) > 1) {
          foreach ($content->features as $value) {
            if (strpos(strtoupper($value->place_name), $province)) {
              $dataFind = $value->geometry->coordinates;
              break;
            }
          }
        }
        if ($dataFind == null) {
          $dataFind = $content->features[0]->geometry->coordinates;
        }
        $data[$index] = $dataFind;
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($geoCodingFilePath, stripslashes($newJsonString));
        $this->townGeocoding = $data;
        return $data[$index];
      }
      return null;
    } catch (\Throwable $th) {
      //return null;
      throw $th;
    }
  }
}
