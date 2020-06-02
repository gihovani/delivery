<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
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

    public function getImageUrlAttribute()
    {
        $image = Str::slug($this->name, '-', 'pt_BR') . '.png';
        $imagePath = '/images/products/' . $this->category_id . '/';
        $imageUrl = $imagePath . $image;
        if (!file_exists(public_path() . $imageUrl)) {
            $imageUrl = $imagePath . 'noimage.png';
        }
        return asset($imageUrl);
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
}
