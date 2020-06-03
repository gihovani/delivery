<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $item = new ItemResource($this->item);

        $data = parent::toArray($request);
        $data['item'] = $item->toArray($request);
        return $data;
    }
}
