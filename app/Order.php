<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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

    public static function create($data = [])
    {
        if (isset($data['user_id'])) {
            $user = User::find($data['user_id'], ['name', 'telephone'])->first();
            $data['user_name'] = $user->name;
            $data['user_telephone'] = $user->telephone;
        }
        if (isset($data['address_id'])) {
            $address = Address::find($data['address_id'])->first();
            $data['address_zipcode'] = $address->zipcode;
            $data['address_street'] = $address->street;
            $data['address_number'] = $address->number;
            $data['address_city'] = $address->city;
            $data['address_state'] = $address->state;
            $data['address_neighborhood'] = $address->neighborhood;
            $data['address_complement'] = $address->complement;
        }
        return parent::create($data);
    }

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
}
