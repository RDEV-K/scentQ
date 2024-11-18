<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KlaviyoProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "link" => route('product', [$this->type, $this->brand->slug, $this->slug]),
            "description" => strip_tags($this->content),
            "price" => $this->additional_price,
            "image_link" => $this->image['url'],
            "categories" => [
                $this->brand?->slug,
            ],
            "inventory_quantity" => $this->stock,
            "inventory_policy" => 1
        ];
    }
}
