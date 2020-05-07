<?php

namespace App\Http\MyTrait;
/**
 * 
 */
trait GeoConding
{
    private $townGeocoding = [];
    public function addTownGeoCoding($town, $province)
    {
        try {
            $MAP_BOX_KEY = env('MAP_BOX_KEY');
            $data = [];
            $town=strtoupper($town);
            $province=strtoupper($province);
            $provinceCopy = $province;
            $index=$province. '_' .$town;
            switch ($province) {

                case 'KONGO-CENTRAL':
                    $provinceCopy = "Bas-Congo";
                    break;
                case 'NORD-UBANGI':
                    $provinceCopy = "Équateur";
                    break;
                case "KASAï":
                case "KASAï":
                case "KASAï-CENTRAL":
                case "KASAI-CENTRAL":
                $provinceCopy="Kasaï-Occidental";
                break;
                default:
                    # code...
                    break;
            }

            if ($province == $town) {
                $provinceCopy = null;
            }
            if (file_exists(storage_path('app/townGeocoding.json'))) {
                $jsonString = file_get_contents(storage_path('app/townGeocoding.json'));
                $data = json_decode($jsonString, true);
                if (array_key_exists($index, $data)) {
                    return $data[$index];
                }
            }
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', "https://api.mapbox.com/geocoding/v5/mapbox.places/{$town}, {$provinceCopy}.json?access_token={$MAP_BOX_KEY}&country=cd");
            $content = json_decode($response->getBody()->getContents());
            $dataFind = null;
            if ($content && isset($content->features[0])) {
                if (count($content->features) > 1) {
                    foreach ($content->features as $value) {
                        if (strpos($value->place_name, strtoupper($province))) {
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
                file_put_contents(storage_path('app/townGeocoding.json'), stripslashes($newJsonString));
                $this->townGeocoding = $data;
                return $data[$index];
            }
            return null;
        } catch (\Throwable $th) {
            return null;
        }
    }
}
