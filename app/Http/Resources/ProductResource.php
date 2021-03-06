<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $category = new CategoryResource($this->category);

        $data = parent::toArray($request);
        $data['price_formated'] = $this->price_formated;
        $data['image_url'] = $this->image_url;
        $data['category'] = $category->toArray($request);
        return $data;
    }
}
