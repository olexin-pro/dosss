<div class="hidden md:block md:col-span-4 lg:col-span-2">
    <div class="card-body">
        Категории
    </div>

    <div>
        <ul>
            @foreach($categories as $category)
                <li class="my-1">
                    <a href="{{route('app.shop.category.show', $category)}}"
                       class="flex items-center text-gray-600 hover:text-gray-800 py-2"
                       title="{{$category->title}}">
                        {{$category->title}}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
