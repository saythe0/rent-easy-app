<?php

namespace App\Models;

use App\Observers\ProductImageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[ObservedBy([ProductImageObserver::class])]
class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'path',
        'order',
        'alt_text',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function url(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk('public')->url($this->path),
        );
    }
}
