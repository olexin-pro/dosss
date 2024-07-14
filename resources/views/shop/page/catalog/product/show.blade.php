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
                <h1 class="text-4xl">{{$product->title}}</h1>
                <div class="flex justify-between gap-x-4 mt-8">
                    <div class="h-1/3 w-2/4 bg-gray-100 rounded-xl overflow-hidden">
                        <img
                            class="w-full h-full object-contain object-center bg-gray-100"
                            src="https://tailwindui.com/img/ecommerce-images/shopping-cart-page-01-product-02.jpg"
                            alt="image">
                    </div>
                    <div>
                        <p>{{$product->category->title}}</p>
                        <p>{{$product->description}}</p>
                        <div class="flex gap-4 items-center my-8">
                            <p class="text-2xl font-bold">
                                {{number_format($product->price, 0, '.', ' ')}} <small class="font-normal">тенге</small>
                            </p>
                            <a href="#" class="bg-blue-300 hover:bg-blue-400 rounded-xl px-6 py-2.5 text-blue-900 transition duration-300 ease-in-out">
                                Add to cart
                            </a>
                            <a href="#" class="bg-green-300 hover:bg-green-400 rounded-xl px-6 py-2.5 text-green-900 transition duration-300 ease-in-out">
                                Buy now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
</div>
@endsection
