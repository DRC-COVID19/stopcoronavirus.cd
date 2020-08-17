<?php

namespace App\Console\Commands;

use Doctrine\DBAL\Schema\Index;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FluxZoneGeocod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flux:geocod';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->output->title("Starting");
        $zones = DB::select('SELECT origin FROM flux_24 UNION SELECT destination AS origin FROM flux_24 ');
        foreach ($zones as $value) {
            $this->output->title("Starting process {$value->origin}");
            $this->getGeocodong($value->origin);
            $this->output->success("precess successful {$value->origin}");
        }

        $provinces = DB::select('SELECT origin FROM flux24_provinces UNION SELECT destination AS origin FROM flux24_provinces');
        foreach ($provinces as $value) {
            $this->output->title("Starting process {$value->origin}");
            $this->getGeocodong($value->origin);
            $this->output->success("precess successful {$value->origin}");
        }
        $this->output->success("End successful");
    }

    public function getGeocodong($place)
    {
        try {
            $MAP_BOX_KEY = env('MAP_BOX_KEY');
            $data = [];
            $index = strtoupper($place);
            $geoCodingFilePath = storage_path('app/fluxZones.json');
            if (file_exists($geoCodingFilePath)) {
                $jsonString = file_get_contents($geoCodingFilePath);
                $data = json_decode($jsonString, true);
            }
            if (isset($data[$index])) {
                return $data[$index];
            }
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', "https://maps.googleapis.com/maps/api/geocode/json?address={$place}&key=AIzaSyB9bIZWto9SNNpq3cEEGbaudwXnOQS6kg8&components=country:CD");
            $content = json_decode($response->getBody()->getContents());
            $dataFind = null;
            if ($content && isset($content->results[0])) {
                if (count($content->results) > 0) {
                    foreach ($content->results as $value) {
                        $currentPlace = [];
                        $currentPlace['coordinates'] = [$value->geometry->location->lng, $value->geometry->location->lat];
                        $currentPlace['place'] = $value->formatted_address;
                        $dataFind[] = $currentPlace;
                    }
                }
                $data[$index] = $dataFind;
                $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
                file_put_contents($geoCodingFilePath, stripslashes($newJsonString));
                return $data[$index];
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return null;
            // throw $th;
        }
    }
}
