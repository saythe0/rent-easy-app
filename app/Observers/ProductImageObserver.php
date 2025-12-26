<?php

namespace App\Observers;

use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageObserver
{
    /**
     * Handle the ProductImage "created" event.
     */
    public function created(ProductImage $productImage): void
    {
        //
    }

    /**
     * Handle the ProductImage "updated" event.
     */
    public function updated(ProductImage $productImage): void
    {
        $old = $productImage->getOriginal('path');
        $new = $productImage->path;

        if ($old && $old !== $new && Storage::disk('public')->exists($old)) {
            Storage::disk('public')->delete($old);
        }
    }

    /**
     * Handle the ProductImage "deleted" event.
     */
    public function deleted(ProductImage $productImage): void
    {
        if (Storage::disk('public')->exists($productImage->path)) {
            Storage::disk('public')->delete($productImage->path);
        }
    }
}
