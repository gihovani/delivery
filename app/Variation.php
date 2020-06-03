<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Variation extends Model
{
    const IMAGE_PATH = 'images/products/';
    protected $fillable = ['name', 'description'];

    public static function toOptionList()
    {
        $list = [];
        $items = parent::all();
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
        $imagePath = self::IMAGE_PATH . '/';
        $imageUrl = $imagePath . $this->image;
        return Storage::disk('public')->path($imageUrl);
    }

    public function getImageUrlAttribute()
    {
        $imagePath = self::IMAGE_PATH . '/';
        $imageUrl = $imagePath . 'noimage1.png';
        if (file_exists($this->image_path)) {
            $imageUrl = $imagePath . $this->image;
        }
        return Storage::disk('public')->url($imageUrl);
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
