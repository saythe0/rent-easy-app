<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'first_image' => $this->first_image,
            'status' => $this->status->getLabel(),
            'category' => $this->whenLoaded('category', fn () => ProductCategoryResource::make($this->category)),
            'images' => $this->whenLoaded('images', fn () => ProductImageResource::collection($this->images)),
        ];
    }
}
