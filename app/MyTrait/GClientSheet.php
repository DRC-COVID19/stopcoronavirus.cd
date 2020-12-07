<?php

namespace App\MyTrait;

use Google_Client;
use Google_Service_Sheets;
use Google_Service_Sheets_ValueRange;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

trait GClientSheet
{
    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    function getClient()
    {
        $httpClient  = new Client(
            [
                'verify' => false
            ]
        );
        $client = new Google_Client();
        $client->setHttpClient($httpClient);
        $client->setApplicationName('Google Sheets API PHP Quickstart');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAccessType('offline');
        $client->setDeveloperKey(env('GOOGLE_KEY'));
        // $client->setAuthConfig(storage_path('app/credentials.json'));
        //$client->setPrompt('select_account consent');
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        /*$tokenPath = storage_path('app/token.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new \Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }*/
        return $client;
    }

    public function writeSheetValue($spreadsheetId, Google_Service_Sheets_ValueRange  $values, $valueInputOption = "USER_ENTERED")
    {

        // Get the API client and construct the service object.
        $client = $this->getClient();
        $service = new Google_Service_Sheets($client);

        $body = new Google_Service_Sheets_ValueRange([
            'values' => $values
        ]);
        $params = [
            'valueInputOption' => $valueInputOption,
            "insertDataOption" => "INSERT_ROWS",
        ];
        $result = $service->spreadsheets_values->append(
            $spreadsheetId,
            "A2",
            $body,
            $params
        );
        return $result;
        Log::debug($result->getSpreadsheetId());
        //printf("%d cells updated.", $result->getUpdatedCells());
    }

    public function readSheetValue($spreadsheetId,$range)
    {
        $client = $this->getClient();
        $service = new Google_Service_Sheets($client);
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        return $response->getValues();
    }
}
