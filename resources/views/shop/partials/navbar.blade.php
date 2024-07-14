<nav class="sticky top-0 flex justify-between gap-4 px-20 py-6 items-center bg-white">
    <a href="{{route('app.home')}}" class="text-xl text-gray-800 font-bold">
        {{config('app.name')}}
    </a>
    <button class="px-3 pb-1 pt-0.5 text-4xl bg-blue-400 hover:bg-blue-500 rounded-xl text-white">=</button>
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
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="hidden dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>

