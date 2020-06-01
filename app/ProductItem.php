<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    protected $fillable = ['name', 'price'];

    public static function toOptionList($withPrice = false)
    {
        $list = [];
        $items = parent::all();
        foreach ($items as $item) {
            $list[$item->id] = $item->name . ($withPrice ? ' R$ ' . number_format($item->price, 2, ',', '.') : '');
        }
        return $list;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
