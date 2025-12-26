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
            'slug' => $this->slug,
            'name' => $this->name,
            'price' => $this->price,
            'status' => $this->status->getLabel(),
            'condition' => $this->condition->getLabel(),
            'description' => $this->description,
            'brand' => $this->brand,
            'model' => $this->model,
            'first_image' => ProductImageResource::make($this->first_image),
            'category' => $this->whenLoaded('category', fn () => ProductCategoryResource::make($this->category)),
            'images' => $this->whenLoaded('images', fn () => ProductImageResource::collection($this->images)),
        ];
    }
}
