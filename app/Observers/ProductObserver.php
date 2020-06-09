<?php

namespace App\Observers;

use App\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductObserver
{
    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        if (Storage::exists($product->image_path) && $product->name !== $product->getOriginal('name')) {
            $newName = Str::slug($product->name, '-', 'pt_BR') . '.png';
            $newPath = str_replace($product->image, $newName, $product->image_path);
            Storage::move($product->image_path, $newPath);
        }
    }

    /**
     * Handle the product "deleted" event.
     *
     * @param  \App\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        if (Storage::exists($product->image_path)) {
            Storage::delete($product->image_path);
        }
    }
}
