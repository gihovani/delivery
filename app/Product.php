<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    const IMAGE_PATH = 'products';
    protected $fillable = ['category_id', 'name', 'description', 'price', 'pieces'];

    public static function toOptionList()
    {
        $list = [];
        $items = parent::all();
        foreach ($items as $item) {
            $list[$item->id] = $item->name;
        }
        return $list;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variations()
    {
        return $this->belongsToMany(Variation::class)->orderBy('name');
    }
    public function getPriceFormatedAttribute()
    {
        return self::formatMoney($this->price);
    }
    public function getImageAttribute()
    {
        return Str::slug($this->name, '-', 'pt_BR') . '.png';
    }

    public static function getFilePath()
    {
        return (env('IMAGES_PATH', '') ? env('IMAGES_PATH', '') . '/' : '') . self::IMAGE_PATH . '/';
    }

    public function getImagePathAttribute()
    {
        return self::getFilePath() . $this->image;
    }

    public function getImageUrlAttribute()
    {
        $imagePath = self::IMAGE_PATH . '/';
        $imageUrl = $imagePath . $this->image;
        if (env('CHECK_IMAGE_PRODUCT_EXIST', 1) &&
            !Storage::exists($this->image_path)) {
            $imageUrl = $imagePath . 'noimage' . $this->category_id . '.png';
        }
        return Storage::url($imageUrl);
    }

    public function getVariationToOptionList($withEmpty = false)
    {
        $list = [];
        if ($withEmpty) {
            $list[''] = '';
        }
        $items = $this->getVariationAttribute();
        foreach ($items as $item) {
            $list[$item->variation_id] = $item->name;
        }
        return $list;
    }

    public function getVariationAttribute()
    {
        $list = [];
        $items = $this->belongsToMany(Variation::class)
            ->select('variation_id', 'name', 'description')
            ->orderBy('name')
            ->getResults();
        foreach ($items as $item) {
            $list[$item->variation_id] = $item;
        }
        return $list;
    }
}
