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
        $data['created_at'] = $this->created_at->format('d/m/Y H:i:s');
        $data['updated_at'] = $this->updated_at->format('d/m/Y H:i:s');
        $data['cash_amount_formated'] = $this->cash_amount_formated;
        $data['total_formated'] = $this->total_formated;
        $data['back_change_formated'] = $this->back_change_formated;
        $data['subtotal_formated'] = $this->subtotal_formated;
        $data['discount_formated'] = $this->discount_formated;
        $data['shipping_amount_formated'] = $this->shipping_amount_formated;
        $data['items'] = $this->items;
        return $data;
    }
}
