<?php

namespace App\Observers;

use App\Variation;
use Illuminate\Support\Str;

class VariationObserver
{

    /**
     * Handle the variation "updated" event.
     *
     * @param  \App\Variation  $variation
     * @return void
     */
    public function updated(Variation $variation)
    {
        if (file_exists($variation->image_path) && $variation->name !== $variation->getOriginal('name')) {
            $newName = Str::slug($variation->name, '-', 'pt_BR') . '.png';
            $newPath = str_replace($variation->image, $newName, $variation->image_path);
            rename($variation->image_path, $newPath);
        }
    }

    /**
     * Handle the variation "deleted" event.
     *
     * @param  \App\Variation  $variation
     * @return void
     */
    public function deleted(Variation $variation)
    {
        if (file_exists($variation->image_path)) {
            unlink($variation->image_path);
        }
    }
}
