<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'short_title' => $this->short_title,
            'is_published' => $this->is_published,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'image_url' => $this->image_url,
            'category' => $this->whenLoaded('category', fn () => PostCategoryResource::make($this->category)),
            'author' => $this->whenLoaded('author', fn () => ShortUserResource::make($this->author)),
            'created_at' => $this->created_at->format('d.m.Y в H:i'),
        ];
    }
}
