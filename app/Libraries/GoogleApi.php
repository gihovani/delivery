<?php


namespace App\Libraries;


use GuzzleHttp\Client;

abstract class GoogleApi
{
    /**
     * base URL
     */
    protected $apiBaseUrl = 'https://maps.googleapis.com/maps/api/geocode/';
    /**
     * holds google api key
     * @var string
     */
    protected $googleApiKey;
    /**
     * guzzle client
     * @var Client
     */
    protected $client;

    /**
     * saves google api key and initializes guzzle client
     */
    public function __construct($apiBaseUrl, $apiKey = null)
    {
        if (is_null($apiKey) && function_exists('config')) {
            $apiKey = config('google.api_key');
        }
        $this->googleApiKey = $apiKey;
        $this->client = new Client($this->guzzleClientOptions($apiBaseUrl));
    }

    /**
     * returns options for the guzzle client
     * @param string $apiBaseUrl
     * @return array
     */
    private function guzzleClientOptions($apiBaseUrl)
    {
        return [
            'base_uri' => $apiBaseUrl,
            'defaults' => [
                'verify' => 'true',
            ]
        ];
    }

    /**
     * @param $queryString string
     * @return array
     */
    protected function getBodyFromQueryString($queryString)
    {
        $response = $this->client->get($queryString);
        return json_decode($response->getBody(), true, 512);
    }
}
