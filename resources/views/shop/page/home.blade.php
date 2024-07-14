@extends('layouts.app')

@section('content')
<div class="container mx-auto my-8">
    @if (session('status'))
        <div>
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        </div>
    @endif
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-x-4">
        @include('shop.partials.category_list')

        <div class="col-span-full md:col-span-8 lg:col-span-10">

            @if (\Illuminate\Support\Facades\Route::currentRouteName() === 'app.shop.search')
                <div class="text-2xl mb-8 text-gray-400">
                    Результаты поиска, по запросу: <strong class="text-gray-500">{{request('q')}}</strong>...
                </div>
            @endif
            <div class="grid grid-cols-4 gap-4">

                @foreach($products as $product)
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
                        <p class="text-sm font-light mt-1">4 500 t</p>
                        <div>
                            <a href="#" class="bg-blue-300 hover:bg-blue-400 rounded-xl px-6 py-2.5 text-blue-900 transition duration-300 ease-in-out">
                                Add to cart
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <div class="my-8">
                {{$products->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
