<?php

namespace App\Libraries;

use GuzzleHttp\Client;

class DistanceMatrix extends GoogleApi
{
    /**
     * saves google api key and initializes guzzle client
     */
    public function __construct($apiKey = null)
    {
        parent::__construct('https://maps.googleapis.com/maps/api/distancematrix/', $apiKey);
    }

    /**
     * makes request to google maps api to fetch distance between origin to destination
     * @param string $origin - location or postalcode
     * @param string $destination - location or postalcode
     * @return array('distance' => ['text' => '...', 'value' => '...'], 'duration' => ['text' => '...', 'value' => '...'])
     */
    public function between($origin, $destination)
    {
        $queryString = $this->constructQueryString($origin, $destination);
        $results = $this->getBodyFromQueryString($queryString);
        if (isset($results['error_message'])) {
            throw new GoogleApiException($results['error_message']);
        }
        if (!isset($results['rows']) || !count($results['rows'])) {
            return [];
        }

        return $results['rows'][0]['elements'][0];
    }

    /**
     * constructs the query string used in the google api request
     * @param string $origin - location or postalcode
     * @param string $destination - location or postalcode
     * @return string
     */
    private function constructQueryString($origin, $destination)
    {
        return 'json?&sensor=false&origins=' . urlencode($origin) . '&destinations=' . $destination . '&key=' . $this->googleApiKey;
    }
}

