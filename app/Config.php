<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Config extends Model
{
    protected $fillable = ['store', 'address', 'zipcode', 'telephone', 'is_open', 'waiting_time', 'google_maps'];

    const DEFAULT_WAITING_TIME = 60;
    const IMAGE_PATH = '';
    const WHATSAPP_API = 'https://api.whatsapp.com/send?lang=pt_br&phone=+55';
    const MAPS_API = 'https://www.google.com.br/maps/dir/';

    public static function getValue($config)
    {
        $order = self::where('id', 1)->first();
        $order->image_url = $order->getImageUrlAttribute();
        return $order->{$config};
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
        $this->attributes['telephone'] = preg_replace('/\D/', '', $value);
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

    public static function getFilePath()
    {
        return (env('IMAGES_PATH', '') ? env('IMAGES_PATH', '') . '/' : '') . self::IMAGE_PATH . '/';
    }

    public function getImagePathAttribute()
    {
        return self::getFilePath() . $this->image;
    }
}
