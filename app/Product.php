<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variations()
    {
        return $this->belongsToMany(Variation::class);
    }

    public function getVariationAttribute()
    {
        $list = [];
        $items = $this->belongsToMany(Variation::class)
            ->select('variation_id','price')
            ->getResults();
        foreach ($items as $item) {
            $list[$item->variation_id] = $item->price;
        }
        return $list;
    }

    public function items()
    {
        return $this->belongsToMany(ProductItem::class);
    }

    public static function toOptionList()
    {
        $list = [];
        $items = parent::all();
        foreach ($items as $item) {
            $list[$item->id] = $item->name;
        }
        return $list;
    }
}
