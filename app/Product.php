<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    CONST IMAGE_PATH = 'images/products/';
    protected $fillable = ['category_id', 'name', 'description'];

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

    private function getPath()
    {
        return self::IMAGE_PATH . $this->category_id;
    }
    public function getImageAttribute()
    {
        return Str::slug($this->name, '-', 'pt_BR') . '.png';
    }

    public function getImagePathAttribute()
    {
        $imagePath = $this->getPath() . '/';
        $imageUrl = $imagePath . $this->image;
        return Storage::disk('public')->path($imageUrl);
    }

    public function getImageUrlAttribute()
    {
        $imagePath = $this->getPath() . '/';
        $imageUrl = $imagePath . 'noimage.png';
        if (file_exists($this->image_path)) {
            $imageUrl = $imagePath . $this->image;
        }
        return Storage::url($imageUrl);
    }

    public function getVariationAttribute()
    {
        $list = [];
        $items = $this->belongsToMany(Variation::class)
            ->select('variation_id', 'price')
            ->getResults();
        foreach ($items as $item) {
            $list[$item->variation_id] = $item->price;
        }
        return $list;
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function delete()
    {
        unlink($this->image_path);
        return parent::delete();
    }
}
