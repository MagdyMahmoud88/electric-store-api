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
        'id'    => $this->id,
        'name'  => $this->name,
        'price' => $this->price,
        'stock' => $this->stock,
        'image_url' => $this->image ? asset('storage/app/products/' . $this->image) : asset('images/default.png'),
        'category' => [
            'id' => $this->category->id,
            'name' => $this->category->name,
        ],

    ];
    }
}
