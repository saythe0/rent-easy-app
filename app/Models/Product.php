<?php

namespace App\Models;

use App\Enums\ProductConditionEnum;
use App\Enums\ProductStatusEnum;
use App\Observers\ProductObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[ObservedBy([ProductObserver::class])]
class Product extends Model
{
    use HasSlug;

    protected $fillable = [
        'slug',
        'name',
        'price',
        'status',
        'condition',
        'description',
        'brand',
        'model',
        'is_active',
        'product_category_id',
    ];

    protected function casts(): array
    {
        return [
            'condition' => ProductConditionEnum::class,
            'status' => ProductStatusEnum::class,
            'is_active' => 'boolean',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function firstImage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->images->first(),
        );
    }
}
