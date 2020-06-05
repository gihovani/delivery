<?php

namespace App\Observers;

use App\Address;
use App\Order;
use App\User;

class OrderObserver
{
    /**
     * Handle the order "creating" event.
     *
     * @param \App\Order $order
     * @return void
     */
    public function creating(Order $order)
    {
        if ($user = $this->getUser($order->customer_id)) {
            $order->customer_name = $user->name;
            $order->customer_telephone = $user->telephone;
        }

        if ($user = $this->getUser($order->deliveryman_id)) {
            $order->deliveryman_name = $user->name;
            $order->deliveryman_telephone = $user->telephone;
        } else {
            $order->deliveryman_id = null;
            $order->deliveryman_name = __(User::DELIVERY_PICK_UP_IN_STORE);
            $order->deliveryman_telephone = '';
        }

        if ($address = $this->getAddress($order->address_id)) {
            $order->address_zipcode = $address->zipcode;
            $order->address_street = $address->street;
            $order->address_number = $address->number;
            $order->address_city = $address->city;
            $order->address_state = $address->state;
            $order->address_neighborhood = $address->neighborhood;
            $order->address_complement = $address->complement;
        }
    }

    private function getUser($userId)
    {
        if (empty($userId)) {
            return null;
        }
        return User::where('id', $userId)->first();
    }

    private function getAddress($addressId)
    {
        if (empty($addressId)) {
            return null;
        }
        return Address::where('id', $addressId)->first();
    }
}
