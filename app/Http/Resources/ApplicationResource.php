<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status->getLabel(),
            'comment' => $this->comment,
            'rental_start_date' => $this->rental_start_date?->format('d.m.Y'),
            'rental_end_date' => $this->rental_end_date?->format('d.m.Y'),
            'amount' => $this->amount,
            'created_at' => $this->created_at->format('d.m.Y в H:i'),
            'product' => $this->whenLoaded('product', fn () => ProductResource::make($this->product)),
            'user' => $this->whenLoaded('user', fn () => ShortUserResource::make($this->user)),
        ];
    }
}
