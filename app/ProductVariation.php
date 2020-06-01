<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = ['name', 'price', 'product_id'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
