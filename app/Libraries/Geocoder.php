<?php

namespace App\Libraries;

class Geocoder extends GoogleApi
{
    public function __construct($apiKey = null)
    {
        parent::__construct('https://maps.googleapis.com/maps/api/geocode/', $apiKey);
    }

    /**
     * makes request to google maps api to fetch coordinates of location
     * @param String $location - location to be converted to coordinates
     * @return array('lat' => '...', 'lng' => '...') - longitude and latitude of location
     */
    public function getCoordinates($location)
    {
        $queryString = $this->constructQueryString($location, 'geocoding');
        $results = $this->getBodyFromQueryString($queryString);
        if (isset($results['error_message'])) {
            throw new GoogleApiException($results['error_message']);
        }
        if (!isset($results['results']) || !count($results['results'])) {
            return [];
        }

        return $results['results'][0]['geometry']['location'];
    }

    /**
     * constructs the query string used in the google api request
     * @param string/array $locationOrCoordinates  - location or coordinates
     * @param string $type - geocoding request or a reverse geocoding request
     * @return string
     */
    private function constructQueryString($locationOrCoordinates, $type)
    {
        switch ($type) {
            case 'geocoding':
                $queryString = 'json?address=' . urlencode($locationOrCoordinates) . '&key=' . $this->googleApiKey;
                break;
            case 'reverse_geocoding':
                $lat = $locationOrCoordinates['lat'];
                $lng = $locationOrCoordinates['lng'];
                $queryString = 'json?latlng=' . $lat . ',' . $lng . '&sensor=true&key=' . $this->googleApiKey;
        }

        return $queryString;
    }

    /**
     * makes request to googlemaps api to fetch address of
     * coordinates using reverse geocoding
     * @param float $longitude - longitudinal coordinate
     * @param float $latitude - latitudinal coordinate
     * @return String             - plain address of coordinates
     */
    public function getAddress($longitude, $latitude)
    {
        $queryString = $this->constructQueryString([
            'lng' => $longitude,
            'lat' => $latitude
        ], 'reverse_geocoding');
        $results = $this->getBodyFromQueryString($queryString);
        if (isset($results['error_message'])) {
            throw new GoogleApiException($results['error_message']);
        }

        return $results['results'][0]['formatted_address'];
    }

    /**
     * fetches the distance between to locations (points)
     * @param float $point1 - coordinates of first location
     * @param float $point2 - coordinates of second location
     * @param string $unit - unit of location (km/mi/nmi)
     * @param integer $decimals - precision
     * @return string             - distance
     */
    public function getDistanceBetween($point1, $point2, $unit = 'km', $decimals = 2)
    {
        // Calculate the distance in degrees using Hervasine formula
        $degrees = $this->calcDistance($point1, $point2);

        // Convert the distance in degrees to the chosen unit (kilometres, miles or nautical miles)
        switch ($unit) {
            case 'km':
                // 1 degree = 111.13384 km, based on the average diameter of the Earth (12,735 km)
                $distance = $degrees * 111.13384;
                break;
            case 'mi':
                // 1 degree = 69.05482 miles, based on the average diameter of the Earth (7,913.1 miles)
                $distance = $degrees * 69.05482;
                break;
            case 'nmi':
                // 1 degree = 59.97662 nautic miles, based on the average diameter of the Earth (6,876.3 nautical miles)
                $distance = $degrees * 59.97662;
        }

        return round($distance, $decimals);
    }

    /**
     * calculates the distance between two points using
     * Haversine formula
     * @param float $point1 - coordinates of first point
     * @param float $point2 - coordinates of second point
     * @return float          - distance between both points
     */
    private function calcDistance($point1, $point2)
    {
        return rad2deg(acos((sin(deg2rad($point1['lat'])) *
                sin(deg2rad($point2['lat']))) +
            (cos(deg2rad($point1['lat'])) *
                cos(deg2rad($point2['lat'])) *
                cos(deg2rad($point1['lng'] - $point2['lng'])))));
    }
}
