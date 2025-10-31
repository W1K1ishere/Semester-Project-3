<x-layout>
    {{--body--}}
    <div class="pl-20 flex flex-row justify-between">
        {{--left side--}}
        <div class="flex flex-col gap-5 pt-32">
            <p class="text-5xl font-bold">Login to your Tabely <br/>account</p>
            <p class="opacity-50">Make your life easier with Tabely</p>
            <a class="bg-black text-white px-4 py-2 w-24 text-center rounded-xl">Login</a>
        </div>
        {{--right side image--}}
        <div class=" overflow-hidden rounded-l-3xl">
            <img src="{{ asset("images/welcome-image.jpg") }}" alt="Office Image" class="object-cover">
        </div>
    </div>
</x-layout>
