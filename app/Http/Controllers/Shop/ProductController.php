<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::query()->with('category')->paginate(50);
        $categories = Category::query()->paginate(50);
        return view('shop.page.home', compact('products', 'categories'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        $products = Product::query()
            ->where('title', 'like', "%{$request->input('q', '===|===')}%")
            ->orWhere('short_description', 'like', "%{$request->input('q', '===|===')}%")
            ->orWhere('description', 'like', "%{$request->input('q', '===|===')}%")
            ->orWhere('search_keys', 'like', "%{$request->input('q', '===|===')}%")
            ->orWhere('barcode', 'like', "%{$request->input('q', '===|===')}%")
            ->orWhere('product_code', 'like', "%{$request->input('q', '===|===')}%")
            ->with('category')
            ->paginate(50);
        $categories = Category::query()->paginate(50);
        return view('shop.page.home', compact('products', 'categories'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function category(Category $category)
    {
        $products = $category->products()->with('category')->paginate(50);
        $categories = Category::query()->paginate(50);
        return view('shop.page.home', compact('products', 'categories'));
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Product $product)
    {
        $categories = Category::query()->paginate(50);
        return view('shop.page.catalog.product.show', compact('product', 'categories'));
    }
}
