<?php

namespace App;

class Item extends Model
{
    protected $fillable = ['name', 'price'];

    public static function toOptionList($withPrice = false)
    {
        $list = [];
        $items = parent::all()->sortBy('name');
        foreach ($items as $item) {
            $list[$item->id] = $item->name . ($withPrice ? ' ' . self::formatMoney($item->price) : '');
        }
        return $list;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
