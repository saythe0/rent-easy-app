<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'text' => $this->comment,
            'date' => $this->created_at?->format('d.m.Y'),
            'user' => $this->whenLoaded('user', fn () => ShortUserResource::make($this->user)),
            'product' => $this->whenLoaded('product', fn () => ProductResource::make($this->product)),
        ];
    }
}
