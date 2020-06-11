<?php

namespace App;

use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'deliveryman_id', 'address_id', 'payment_method',
        'cash_amount', 'amount', 'back_change', 'subtotal', 'discount',
        'shipping_amount', 'additional_amount'
    ];
    protected $dates = ['created_at', 'updated_at', 'expected_at'];

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_CANCELED = 'canceled';
    const STATUS_COMPLETE = 'complete';
    const STATUS_DELIVERY = 'delivery';

    const STATUSES = [
        self::STATUS_PENDING => self::STATUS_PENDING,
        self::STATUS_PROCESSING => self::STATUS_PROCESSING,
        self::STATUS_DELIVERY => self::STATUS_DELIVERY,
        self::STATUS_CANCELED => self::STATUS_CANCELED,
        self::STATUS_COMPLETE => self::STATUS_COMPLETE
    ];

    const METHOD_SUBSIDIZED = 'subsidized';
    const METHOD_CREDIT_CARD = 'credit card';
    const METHOD_DEBIT_CARD = 'debit card';
    const METHOD_FOOD_VOUCHER = 'food voucher';
    const METHOD_MEAL_TICKET = 'meal ticket';
    const METHOD_IN_CASH = 'in cash';

    const PAYMENT_METHODS = [
        self::METHOD_SUBSIDIZED => self::METHOD_SUBSIDIZED,
        self::METHOD_CREDIT_CARD => self::METHOD_CREDIT_CARD,
        self::METHOD_DEBIT_CARD => self::METHOD_DEBIT_CARD,
        self::METHOD_FOOD_VOUCHER => self::METHOD_FOOD_VOUCHER,
        self::METHOD_MEAL_TICKET => self::METHOD_MEAL_TICKET,
        self::METHOD_IN_CASH => self::METHOD_IN_CASH
    ];

    public function getIsLateAttribute()
    {
        if (in_array($this->status, [self::STATUS_PROCESSING, self::STATUS_PENDING])) {
            return !$this->expected_at->greaterThan(Carbon::now());
        }
        return false;
    }
    public function setStatusAttribute($value)
    {
        if (!in_array($value, self::STATUSES)) {
            $value = self::STATUSES[0];
        }
        $this->attributes['status'] = $value;
    }

    public function setPaymentMethodAttribute($value)
    {
        if (!in_array($value, self::PAYMENT_METHODS)) {
            $value = self::PAYMENT_METHODS[0];
        }
        $this->attributes['payment_method'] = $value;
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

    public function getCashAmountFormatedAttribute()
    {
        return self::formatMoney($this->cash_amount);
    }

    public function getAmountFormatedAttribute()
    {
        return self::formatMoney($this->amount);
    }

    public function getSubtotalFormatedAttribute()
    {
        return self::formatMoney($this->subtotal);
    }

    public function getBackChangeFormatedAttribute()
    {
        return self::formatMoney($this->back_change);
    }

    public function getDiscountFormatedAttribute()
    {
        return self::formatMoney($this->discount);
    }

    public function getShippingAmountFormatedAttribute()
    {
        return self::formatMoney($this->shipping_amount);
    }
    public function getAdditionalAmountFormatedAttribute()
    {
        return self::formatMoney($this->additional_amount);
    }
    public function getAddressDistanceFormatedAttribute()
    {
        return self::formatMoney($this->address_distance * 0.001, '') . 'km';
    }
}
