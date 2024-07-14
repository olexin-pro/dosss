<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    public function creating(Product $product)
    {
        $this->setSlugFromTitleIfIsEmpty($product);
    }
    public function updating(Product $product)
    {
        $this->setSlugFromTitleIfIsEmpty($product);
    }

    private function setSlugFromTitleIfIsEmpty(Product $product)
    {
        if (blank($product->slug)){
            $product->slug =  Str::random(8) . '_'. Str::slug($product->title, language: 'ru');
        }
    }
}
