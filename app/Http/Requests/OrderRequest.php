<?php

namespace App\Http\Requests;

use App\Order;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (intval(auth()->user()->id) > 0);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'customer_id' => ['required', 'exists:users,id'],
            'address_id' => ['required', 'exists:addresses,id'],
            'deliveryman_id' => ['required', 'integer'],
            'items' => ['required'],
            'payment_method' => ['required', 'string', 'in:'.implode(',', Order::PAYMENT_METHODS)],
            'subtotal' => ['required', 'string'],
            'discount' => ['required', 'string'],
            'shipping_amount' => ['required', 'string'],
            'additional_amount' => ['required', 'string'],
            'amount' => ['required', 'string'],
            'cash_amount' => ['nullable', 'string'],
            'back_change' => ['nullable', 'string'],
        ];
    }
}
