<?php

namespace App\Observers;

use App\Address;
use App\Config;
use App\Order;
use App\Transaction;
use App\User;

class OrderObserver
{
    public function creating(Order $order)
    {
        $order = $this->setDeliveryman($order);
        if ($user = $this->getUser($order->customer_id)) {
            $order->customer_name = $user->name;
            $order->customer_telephone = $user->telephone;
        }

        $order->expected_at = time() + (intval(Config::getValue('waiting_time')) * 60);
        if ($address = $this->getAddress($order->address_id)) {
            $order->address_zipcode = $address->zipcode;
            $order->address_street = $address->street;
            $order->address_number = $address->number;
            $order->address_city = $address->city;
            $order->address_state = $address->state;
            $order->address_neighborhood = $address->neighborhood;
            $order->address_complement = $address->complement;
            $order->address_distance = $address->distance;
        }
    }

    private function setDeliveryman(Order $order)
    {
        if ($user = $this->getUser($order->deliveryman_id)) {
            $order->deliveryman_name = $user->name;
            $order->deliveryman_telephone = $user->telephone;
        } else {
            $order->deliveryman_id = null;
            $order->deliveryman_name = __(User::DELIVERY_PICK_UP_IN_STORE);
            $order->deliveryman_telephone = '';
            $order->address_id = null;
        }
        return $order;
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

    public function updating(Order $order)
    {
        $order = $this->setDeliveryman($order);
    }

    public function updated(Order $order)
    {
        if ($order->status !== $order->getOriginal('status')
            && $order->status === Order::STATUS_COMPLETE
            && $order->payment_method !== Order::METHOD_SUBSIDIZED
        ) {
            Transaction::create([
                'type' => Transaction::TYPE_SALE,
                'value' => $order->amount,
                'payment_method' => $order->payment_method,
                'description' => __('Order') . ': #' . $order->id
            ]);
        }
    }
}
