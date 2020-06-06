<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['created_at'] = $this->created_at->format('d/m/y H:i:s');
        $data['updated_at'] = $this->updated_at->format('d/m/y H:i:s');
        $data['expected_at'] = $this->expected_at->format('d/m/y H:i:s');
        $data['cash_amount_formated'] = $this->cash_amount_formated;
        $data['amount_formated'] = $this->amount_formated;
        $data['back_change_formated'] = $this->back_change_formated;
        $data['subtotal_formated'] = $this->subtotal_formated;
        $data['discount_formated'] = $this->discount_formated;
        $data['shipping_amount_formated'] = $this->shipping_amount_formated;
        $data['additional_amount_formated'] = $this->additional_amount_formated;
        $data['status'] = __($this->status);
        $data['is_late'] = ($this->is_late) ? __('Is Late') : '';
        $data['payment_method'] = __($this->payment_method);
        $data['items'] = $this->items;
        return $data;
    }
}
