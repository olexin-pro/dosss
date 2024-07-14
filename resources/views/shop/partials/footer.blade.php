<div>
    <nav class="container mx-auto my-8">
        <div class="bg-gray-50 p-8 rounded-xl flex justify-between items-center gap-4">
            <a href="{{route('app.home')}}" class="text-gray-400 hover:text-gray-600 font-semibold text-sm">
                {{config('app.name')}} &copy; {{date('Y')}}
            </a>
            <div class="flex flex-row flex-wrap gap-x-2">
                <a class="text-gray-500 hover:text-gray-600 text-sm" href="#">Insta</a>
                <a class="text-gray-500 hover:text-gray-600 text-sm" href="#">YouTube</a>
                <a class="text-gray-500 hover:text-gray-600 text-sm" href="#">X</a>
            </div>
        </div>
    </nav>
</div>

