
<div class="shadow hover:shadow-xl rounded-xl overflow-hidden transition duration-300 ease-in-out">
    <a href="{{route('app.shop.product.show', $product)}}" title="{{$product->title}}">
        <img
            class="w-full object-contain object-center bg-gray-100"
            src="https://tailwindui.com/img/ecommerce-images/shopping-cart-page-01-product-02.jpg"
            alt="image">
    </a>
    @if(filled($product->category))
        <a href="{{route('app.shop.category.show', $product->category)}}" title="Категория {{$product->category->title}}">
            <h5 class="px-4 text-sm font-semibold text-gray-400">
                {{$product->category->title}}
            </h5>
        </a>
    @endif
    <a href="{{route('app.shop.product.show', $product)}}" title="{{$product->title}}">
        <h4 class="px-4 text-sm font-semibold">
            {{$product->title}}
        </h4>
    </a>
    <div class="p-4 flex justify-between gap-x-4 items-center">
        <p class="text-sm font-light mt-1">
            {{number_format($product->price,0,'.', ' ')}} Тенге
        </p>
        <div>
            <a href="#" class="text-sm bg-blue-300 hover:bg-blue-400 rounded-xl px-6 py-2.5 text-blue-900 transition duration-300 ease-in-out">
                В корзину
            </a>
        </div>
    </div>
</div>
