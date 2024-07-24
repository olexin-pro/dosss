<?php

namespace App\View\Components\Category;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public bool $popup = false) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $categories = Cache::remember('category_paginate', 3600 * 24, function () {
            return Category::query()->paginate(50);
        });
        $popup = $this->popup;
        return view(
            'components.category.menu',
            compact(
                'categories',
                'popup'
            )
        );
    }
}
