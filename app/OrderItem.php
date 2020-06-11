<?php

namespace App;

class OrderItem extends Model
{
    protected $fillable = ['name', 'quantity', 'price', 'description', 'observation', 'product_id'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
