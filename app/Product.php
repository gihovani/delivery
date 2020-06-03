<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    const IMAGE_PATH = 'images/products/';
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
        return $this->belongsToMany(Variation::class);
    }
    public function getPriceFormatedAttribute()
    {
        return 'R$'.number_format($this->price, 2, ',', '.');
    }
    public function getImageAttribute()
    {
        return Str::slug($this->name, '-', 'pt_BR') . '.png';
    }

    public function getImagePathAttribute()
    {
        $imagePath = self::IMAGE_PATH . '/';
        $imageUrl = $imagePath . $this->image;
        return Storage::disk('public')->path($imageUrl);
    }

    public function getImageUrlAttribute()
    {
        $imagePath = self::IMAGE_PATH . '/';
        $imageUrl = $imagePath . 'noimage' . $this->category_id . '.png';
        if (file_exists($this->image_path)) {
            $imageUrl = $imagePath . $this->image;
        }
        return Storage::disk('public')->url($imageUrl);
    }

    public function getVariationToOptionList()
    {
        $list = [];
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
            ->getResults();
        foreach ($items as $item) {
            $list[$item->variation_id] = $item;
        }
        return $list;
    }
}
