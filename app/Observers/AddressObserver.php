<?php

namespace App\Observers;

use App\Address;
use App\Config;
use App\Libraries\DistanceMatrix;

class AddressObserver
{
    private function setGoogleApiDistance(Address $address)
    {
        if ($address->is_google_distance) {
            return $address;
        }
        $address->is_google_distance = 1;
        $address->distance = 0;
        $address->duration = 0;
        if ($address->zipcode === Address::DEFAULT_ZIPCODE) {
            return $address;
        }

        $apiKey = Config::getValue('google_api_key');
        $distance = new DistanceMatrix($apiKey);
        $tmp = $distance->between(Config::getValue('zipcode'), $address->getMapsAddr());
        if (isset($tmp['distance'])) {
            $address->distance = $tmp['distance']['value'] ?? 0;
            $address->duration = $tmp['duration']['value'] ?? 0;
        }
        return $address;
    }
    public function creating(Address $address)
    {
        $address = $this->setGoogleApiDistance($address);
    }

    public function updating(Address $address)
    {
        $address = $this->setGoogleApiDistance($address);
    }
}
