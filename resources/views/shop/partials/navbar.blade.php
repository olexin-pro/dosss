<div class="my-2">
    <div class="container mx-auto text-sm">
        fsddfsdfg
    </div>
</div>
<nav class="sticky top-0 bg-white py-6">
    <div class="container mx-auto flex justify-between gap-4 items-center ">
        <a href="{{route('app.home')}}" class="text-xl text-gray-800 font-bold">
            {{config('app.name')}}
        </a>
        <popup-categories>
            <div class="grid grid-cols-1" v-cloak>
                @foreach($categories as $category)
                    <a href="{{route('app.shop.category.show', $category)}}"
                       class="bg-transparent hover:bg-gray-50 px-4 py-3 flex flex-row justify-between items-center">
                        <span>{{$category->title}}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-300">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                @endforeach
            </div>
        </popup-categories>
        <div class="grow">
            <div class="flex items-center w-full bg-gray-100 px-6 py-4 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 pt-0.5 text-gray-600" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <form action="{{route('app.shop.search')}}" method="get" class="w-full">
                    <input class="ml-2 outline-none font-light w-full bg-transparent text-sm -mb-1"
                           type="text"
                           value="{{request('q', '')}}"
                           name="q"
                           id="app_search"
                           placeholder="Search..."/>
                </form>
            </div>
        </div>
        <div class="flex items-center">
            <ul class="flex items-center space-x-6">
                <li class="font-semibold text-gray-700"><a href="{{route('app.home')}}">Home</a></li>
                <li class="font-semibold text-gray-700">Articles</li>

                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))

                        <li class="font-semibold text-gray-700">
                            <a href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="font-semibold text-gray-700">
                            <a  href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else

                    <li class="font-semibold text-gray-700">

                        <dropdown title="{{ Auth::user()->name }}" v-cloak>
                            <!-- Active: "bg-gray-100", Not Active: "" -->
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();"
                               class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">
                                Sign out
                            </a>
                        </dropdown>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

