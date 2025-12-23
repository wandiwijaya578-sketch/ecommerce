<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        Cache::forget('featured_products');
        Cache::forget('category_' . $product->category_id . '_products');

        if (Auth::check()) {
            logger()->info('Produk baru dibuat', [
                'product_id' => $product->id,
                'name'       => $product->name,
                'user_id'    => Auth::id(),
            ]);
        }
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        Cache::forget('product_' . $product->id);
        Cache::forget('featured_products');

        if ($product->isDirty('category_id')) {
            Cache::forget('category_' . $product->getOriginal('category_id') . '_products');
            Cache::forget('category_' . $product->category_id . '_products');
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        Cache::forget('product_' . $product->id);
        Cache::forget('featured_products');
        Cache::forget('category_' . $product->category_id . '_products');
    }
}
