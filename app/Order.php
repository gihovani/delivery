<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'deliveryman_id', 'address_id', 'payment_method',
        'cash_amount', 'total', 'back_change', 'subtotal', 'discount', 'shipping_amount'
    ];
    protected $dates = ['created_at', 'updated_at'];

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_CANCELED = 'canceled';
    const STATUS_COMPLETE = 'complete';
    const STATUSES = [
        self::STATUS_PENDING => self::STATUS_PENDING,
        self::STATUS_PROCESSING => self::STATUS_PROCESSING,
        self::STATUS_CANCELED => self::STATUS_CANCELED,
        self::STATUS_COMPLETE => self::STATUS_COMPLETE
    ];


    const METHOD_SUBSIDIZED = 'subsidized';
    const METHOD_CREDIT_CARD = 'credit card';
    const METHOD_IN_CASH = 'in cash';

    const PAYMENT_METHODS = [
        self::METHOD_SUBSIDIZED => self::METHOD_SUBSIDIZED,
        self::METHOD_CREDIT_CARD => self::METHOD_CREDIT_CARD,
        self::METHOD_IN_CASH => self::METHOD_IN_CASH
    ];

    public function setStatusAttribute($value)
    {
        if (!in_array($value, self::STATUSES)) {
            $value = self::STATUSES[0];
        }
        $this->attributes['status'] = $value;
    }

    public function getStatusAttribute($value)
    {
        return __($value);
    }

    public function setPaymentMethodAttribute($value)
    {
        if (!in_array($value, self::PAYMENT_METHODS)) {
            $value = self::PAYMENT_METHODS[0];
        }
        $this->attributes['payment_method'] = $value;
    }

    public function getPaymentMethodAttribute($value)
    {
        return __($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function getPaymentMethodToOptionList($withEmpty = true)
    {
        $list = [];
        if ($withEmpty) {
            $list[] = '';
        }
        foreach (array_reverse(self::PAYMENT_METHODS) as $key => $value) {
            $list[$key] = __($value);
        }
        return $list;
    }

    private function formatMoney($value)
    {
        return 'R$' . number_format($value, 2, ',', '.');
    }

    public function getCashAmountFormatedAttribute()
    {
        return $this->formatMoney($this->cash_amount);
    }

    public function getTotalFormatedAttribute()
    {
        return $this->formatMoney($this->total);
    }

    public function getSubtotalFormatedAttribute()
    {
        return $this->formatMoney($this->subtotal);
    }

    public function getBackChangeFormatedAttribute()
    {
        return $this->formatMoney($this->back_change);
    }

    public function getDiscountFormatedAttribute()
    {
        return $this->formatMoney($this->discount);
    }

    public function getShippingAmountFormatedAttribute()
    {
        return $this->formatMoney($this->shipping_amount);
    }
}
