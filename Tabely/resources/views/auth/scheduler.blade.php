<x-layout>
    <div class="flex flex-row flex-1 w-full items-center">
        {{--break side--}}
        <div class="flex-1">
            <div class="flex flex-row gap-2">
                <img src="{{ asset('images/break.png') }}" alt="coffee logo" class="size-12">
                <p class="text-4xl">Schedule Break</p>
            </div>
        </div>
        {{--separating line--}}
        <div class="h-screen w-1 bg-black"></div>
        {{--cleaning side--}}
        <div class="flex-1">
            <div class="flex-row gap-2 items-center">
                <img src="{{ asset('images/cleaning.png') }}" alt="coffee logo" class="size-12">
                <p class="text-4xl">Schedule Cleaning</p>
            </div>
        </div>
    </div>
</x-layout>
