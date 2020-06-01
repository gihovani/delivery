<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function variations()
    {
        return $this->hasMany(Variation::class);
    }

    public static function toOptionList()
    {
        $list = [];
        $categories = parent::all();
        foreach ($categories as $category) {
            $list[$category->id] = $category->name;
        }
        return $list;
    }
}
