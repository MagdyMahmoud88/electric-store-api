<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
// هذا الـ Observer مسؤول عن حذف الصور القديمة تلقائياً عند تحديث أو حذف منتج
class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // إذا تغيرت الصورة، احذف القديمة تلقائياً
    if ($product->isDirty('image_url')) {
        $oldImage = $product->getOriginal('image_url');
        if ($oldImage) {
            Storage::disk('public')->delete($oldImage);
        }
    }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        if ($product->image_url) {
        Storage::disk('public')->delete($product->image_url);
    }
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
