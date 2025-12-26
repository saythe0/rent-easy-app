<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'phone' => $this->phone,
            'role' => $this->role->getLabel(),
            'created_at' => $this->created_at->format('d.m.Y в H:i'),
        ];
    }
}
