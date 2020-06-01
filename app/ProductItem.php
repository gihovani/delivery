<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    protected $fillable = ['name', 'price'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps();
    }
}
