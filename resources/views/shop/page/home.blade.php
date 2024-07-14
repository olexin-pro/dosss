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
                    <x-product.card :product="$product"/>
                @endforeach

            </div>
            <div class="my-8">
                {{$products->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
