<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    const DEFAULT_EMAIL = '@noemail.com';
    const ROLE_CUSTOMER = 'customer';
    const ROLE_ADMIN = 'admin';
    const ROLE_DELIVERYMAN = 'deliveryman';
    const ROLES = [
        self::ROLE_CUSTOMER => self::ROLE_CUSTOMER,
        self::ROLE_ADMIN => self::ROLE_ADMIN,
        self::ROLE_DELIVERYMAN => self::ROLE_DELIVERYMAN
    ];

    const DELIVERY_PICK_UP_IN_STORE = 'Pick Up in Store';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'telephone', 'roles'
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

    public function getTelephoneAttribute($value)
    {
        $len = strlen($value);
        if ($len >= 10 && $len <= 11) {
            $regex = "/([0-9]{2})([0-9]{4})([0-9]{4})/";
            if ($len === 11) {
                $regex = "/([0-9]{2})([0-9]{5})([0-9]{4})/";
            }
            return preg_replace($regex, "($1) $2-$3", $value);

        }
        return $value;
    }

    public function setTelephoneAttribute($value)
    {
        $this->attributes['telephone'] = Model::onlyNumbers($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = (strlen($value) < 20) ? Hash::make($value) : $value;
    }

    public function setRolesAttribute($value)
    {
        $roles = [];
        $values = (is_array($value)) ? $value : explode(',', $value);
        foreach ($values as $role) {
            $role = trim($role);
            if (in_array($role, self::ROLES)) {
                $roles[] = $role;
            }
        }
        if (empty($roles)) {
            $roles[] = self::ROLES[0];
        }
        $this->attributes['roles'] = implode(',', $roles);
    }

    public function getRolesTranslatedAttribute($value)
    {
        $roles = [];
        $values = explode(',', $value);
        foreach ($values as $role) {
            $roles[] = __(trim($role));
        }
        return implode(',', $roles);
    }

    public static function rolesToOptionList()
    {
        $list = [];
        foreach (self::ROLES as $item) {
            $list[$item] = __($item);
        }
        return $list;
    }

    public static function getDeliveryman($withPickUpInStore = true)
    {
        $roleCustomer = self::ROLE_DELIVERYMAN;
        $list = [];
        if ($withPickUpInStore) {
            $list[0] = __(self::DELIVERY_PICK_UP_IN_STORE);
        }
        $collection = static::query()
            ->where('roles', 'like', "%{$roleCustomer}%")
            ->get(['id', 'name']);
        foreach ($collection as $item) {
            $list[$item->id] = $item->name;
        }
        return $list;
    }

    public function isAdmin()
    {
        return $this->hasRole(self::ROLE_ADMIN);
    }

    public function isCustomer()
    {
        return $this->hasRole(self::ROLE_CUSTOMER);
    }

    public function isDeliveryMan()
    {
        return $this->hasRole(self::ROLE_DELIVERYMAN);
    }

    private function hasRole($roleName = '')
    {
        $roles = explode(',', $this->roles);
        return (in_array($roleName, $roles));
    }

}
