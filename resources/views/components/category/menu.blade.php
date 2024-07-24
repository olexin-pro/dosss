<ul>
    @foreach($categories as $category)
        @if($popup)

            <a href="{{route('app.shop.category.show', $category)}}"
               class="bg-transparent hover:bg-gray-50 px-4 py-3 flex flex-row justify-between items-center">
                <span>{{$category->title}}</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-300">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        @else
            <li class="my-1">
                <a href="{{route('app.shop.category.show', $category)}}"
                   class="flex items-center text-gray-600 hover:text-gray-800 py-2"
                   title="{{$category->title}}">
                    {{$category->title}}
                </a>
            </li>
        @endif
    @endforeach
</ul>
