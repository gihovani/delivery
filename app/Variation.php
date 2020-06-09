<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Variation extends Model
{
    const IMAGE_PATH = 'products';
    protected $fillable = ['name', 'description'];


    public static function toOptionList()
    {
        $list = [];
        $items = parent::all()->sortBy('name');
        foreach ($items as $item) {
            $list[$item->id] = $item->name;
        }
        return $list;
    }

    public function getImageAttribute()
    {
        return Str::slug($this->getOriginal('name'), '-', 'pt_BR') . '.png';
    }

    public function getImagePathAttribute()
    {
        $imagePath = (env('IMAGES_PATH', '') ? env('IMAGES_PATH', '') . '/' : '') . self::IMAGE_PATH . '/';
        return $imagePath . $this->image;
    }

    public function getImageUrlAttribute()
    {
        $imagePath = (env('IMAGES_PATH', '') ? env('IMAGES_PATH', '') . '/' : '') . self::IMAGE_PATH . '/';
        $imageUrl = $imagePath . $this->image;
        if (env('CHECK_IMAGE_PRODUCT_EXIST', 1) &&
            !Storage::exists($this->image_path)) {
            $imageUrl = $imagePath . 'noimage1.png';
        }
        return Storage::url($imageUrl);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
