<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'telephone', 'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function createWithAddress($data)
    {
        $user = parent::create($data);
        $user->addresses()->create($data);
        return $user;
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public static function types()
    {
        return [__('Customer'), __('Admin')];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = (strlen($value) < 20) ? Hash::make($value) : $value;
    }

}
