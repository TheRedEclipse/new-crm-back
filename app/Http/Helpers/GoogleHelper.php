<?php

namespace App\Http\Helpers;

use Google_Client;
use Google_Service_Sheets;

class GoogleHelper
{
    /**
     * Returns an authorized API client.
     * @return Google_Client the authorized client object
     */
    public function getClient()
    {
        $client = new Google_Client();
        $client->setRedirectUri('http://' . 'modernciti.group' . '/oauth2callback.php');
        $client->setApplicationName('Google Sheets API');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
        $client->setAuthConfig(base_path().'/credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = base_path().'/token.json';
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
                // // Request authorization from the user.
                // $authUrl = $client->createAuthUrl();
                // printf("Open the following link in your browser:\n%s\n", $authUrl);
                // print 'Enter verification code: ';
                // $authCode = trim(fgets(STDIN));

                // // Exchange authorization code for an access token.
                // $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                // $client->setAccessToken($accessToken);

                // // Check to see if there was an error.
                // if (array_key_exists('error', $accessToken)) {
                //     throw new Exception(join(', ', $accessToken));
                // }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }
}
