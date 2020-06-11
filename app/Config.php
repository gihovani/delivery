<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Config extends Model
{
    const DEFAULT_WAITING_TIME = 60;
    const IMAGE_PATH = '';
    const WHATSAPP_API = 'https://api.whatsapp.com/send?lang=pt_br&phone=+55';
    const MAPS_API = 'https://www.google.com.br/maps/dir/%s/';
    const MAPS_DISTANCE_API = 'http://maps.googleapis.com/maps/api/distancematrix/json?origins=%s&destinations={0}&sensor=false';
    public static $values;
    protected $fillable = ['store', 'address', 'zipcode', 'latitude', 'longitude', 'telephone', 'is_open', 'shipping_tax', 'waiting_time', 'free_distance', 'google_maps'];

    public static function getWhatsappApi()
    {
        return self::WHATSAPP_API;
    }

    public static function getMapsApi()
    {
        return sprintf(self::MAPS_API, self::getValue('zipcode'));
    }

    public static function getMapsDistanceApi()
    {
        return sprintf(self::MAPS_DISTANCE_API, self::getValue('zipcode'));
    }

    public static function getValue($config)
    {
        if (!self::$values) {
            $config = self::where('id', 1)->first();
            $config->image_url = $config->getImageUrlAttribute();
            self::$values = $config;
        }
        return self::$values->{$config};
    }

    public function getTelephoneAttribute($value)
    {
        $len = strlen($value);
        if ($len >= 10 && $len <= 11) {
            $regex = "/([0-9]{2})([0-9]{4})([0-9]{4})/";
            if ($len === 11) {
                $regex = "/([0-9]{2})([0-9]{5})([0-9]{4})/";
            }
            return preg_replace($regex, "($1) $2-$3", $value);

        }
        return $value;
    }

    public function setTelephoneAttribute($value)
    {
        $this->attributes['telephone'] = self::onlyNumbers($value);
    }

    public function getImageAttribute()
    {
        return Str::slug($this->store, '-', 'pt_BR') . '.png';
    }

    public function getImageUrlAttribute()
    {
        $imagePath = self::IMAGE_PATH . '/';
        $imageUrl = $imagePath . $this->image;
        if (env('CHECK_IMAGE_PRODUCT_EXIST', 1) &&
            !Storage::exists($this->image_path)) {
            $imageUrl = $imagePath . 'logo.png';
        }
        return Storage::url($imageUrl);
    }

    public function getImagePathAttribute()
    {
        return self::getFilePath() . $this->image;
    }

    public static function getFilePath()
    {
        return (env('IMAGES_PATH', '') ? env('IMAGES_PATH', '') . '/' : '') . self::IMAGE_PATH . '/';
    }
}
