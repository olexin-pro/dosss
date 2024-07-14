<?php

namespace App\Observers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class CategoryObserver
{
    public function creating(Category $category)
    {
        $this->setSlugFromTitleIfIsEmpty($category);
    }
    public function updating(Category $category)
    {
        $this->setSlugFromTitleIfIsEmpty($category);
    }

    private function setSlugFromTitleIfIsEmpty(Category $category)
    {
        if (blank($category->slug)){
            $category->slug =  Str::random(8) . '_'. Str::slug($category->title, language: 'ru');
        }
    }
}
