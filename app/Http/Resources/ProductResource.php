<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'discount' => $this->discount,
            'discounted_price' => $this->discounted_price,
            'stock' => $this->stock,
            'image_url' => $this->image_url,
            'average_rating' => $this->average_rating,
            'ratings_count' => $this->ratings_count,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'brand' => $this->brand ? [
                'id' => $this->brand->id,
                'name' => $this->brand->name,
            ] : null,
        ];
    }
}
