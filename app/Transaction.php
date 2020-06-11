<?php

namespace App;

class Transaction extends Model
{
    const TYPE_SALE = 'sale';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPES = [
        self::TYPE_SALE => self::TYPE_SALE,
        self::TYPE_WITHDRAWAL => self::TYPE_WITHDRAWAL
    ];
    protected $fillable = ['type', 'value', 'payment_method', 'description'];

    public function setTypeAttribute($value)
    {
        if (!in_array($value, self::TYPES)) {
            $value = self::TYPES[0];
        }
        $this->attributes['type'] = $value;
    }

    public function setPaymentMethodAttribute($value)
    {
        if (!in_array($value, Order::PAYMENT_METHODS)) {
            $value = Order::METHOD_IN_CASH;
        }
        $this->attributes['payment_method'] = $value;
    }
}
