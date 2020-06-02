<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const TYPE_SALE = 'sale';
    const TYPE_WITHDRAWAL = 'withdrawal';
    const TYPES = [
        self::TYPE_SALE => self::TYPE_SALE,
        self::TYPE_WITHDRAWAL => self::TYPE_WITHDRAWAL
    ];
    protected $fillable = ['type', 'value', 'description'];

    public function setTypeAttribute($value)
    {
        if (!in_array($value, self::TYPES)) {
            $value = self::TYPES[0];
        }
        $this->attributes['type'] = $value;
    }

    public function getTypeAttribute($value)
    {
        return __($value);
    }
}
