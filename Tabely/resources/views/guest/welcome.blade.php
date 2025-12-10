<x-layout>
    {{--body--}}
    <div class="pl-20 flex flex-row justify-between">
        {{--left side--}}
        <div class="flex flex-col gap-5 pt-32">
            @guest
                <p class="text-5xl font-bold">Login to your Tabely <br/>account</p>
                <p class="opacity-50">Make your life easier with Tabely</p>
                <a href="/login" class="bg-black text-white px-4 py-2 w-24 text-center rounded-xl hover:bg-gray-900 hover:scale-95 transition-transform active:scale-90 active:bg-gray-700">Login</a>
            @endguest
            @auth
                <p class="text-5xl font-bold">Explore your Tabely account</p>
                <p class="opacity-50">Tabely is making your everyday life easier</p>
                <a href="/profile/{{ Auth()->user() }}" class="bg-black text-white px-4 py-2 w-24 text-center rounded-xl hover:bg-gray-900 hover:scale-95 transition-transform active:scale-90 active:bg-gray-700">Explore</a>
            @endauth
        </div>
        {{--right side image--}}
        <div class=" overflow-hidden rounded-l-3xl">
            <img src="{{ asset("images/welcome-image.jpg") }}" alt="Office Image" class="object-cover">
        </div>
    </div>
</x-layout>
