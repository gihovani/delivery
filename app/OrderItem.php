<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['name', 'quantity', 'price', 'description', 'observation', 'product_id'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
