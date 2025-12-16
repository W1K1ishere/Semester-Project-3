<x-layout>
    <div class="w-screen h-screen flex flex-col items-center">
        {{--weather widget--}}
        <div class="relative bg-orange-50 w-[calc(100%-200px)] h-[150px] mt-10 rounded-3xl overflow-hidden shadow-2xl" id="weather" >
            {{--background--}}
            <video autoplay loop playsinline muted class="w-full h-full object-cover rounded-3xl absolute inset-0">
                <source src="{{ asset('weather/clearDay.mp4') }}" type="video/mp4">
            </video>
            {{--weather informations--}}
            <div class="relative flex flex-row rounded-3xl justify-between z-30 px-10 pt-8">
                <div class="flex flex-row items-center">
                    <label class="text-4xl text-white">Detecting...</label>
                    <img src="{{ asset('images/clearDay.png') }}" alt="weather icon" class="size-16">
                </div>
                <div class="flex flex-row items-center">
                    <label class="text-4xl text-white">--°C</label>
                    <img src="{{ asset('images/temperature.png') }}" alt="temperature" class="size-16">
                </div>
                <div class="flex flex-row items-center">
                    <label class="text-4xl text-white">--%</label>
                    <img src="{{ asset('images/humidity.png') }}" alt="humidity" class="size-16">
                </div>
                <div class="flex flex-row items-center">
                    <label class="text-4xl text-white">-- m/s</label>
                    <img src="{{ asset('images/wind.png') }}" alt="wind" class="size-16">
                </div>
            </div>
        </div>
        {{--office temperature, humidity--}}
        @foreach($currentConditions as $currentCondition)
            <x-department-condition :currentCondition="$currentCondition"></x-department-condition>
        @endforeach
    </div>
</x-layout>
<script>
    window.ASSETS = {
        images: "{{ asset('images') }}",
        weather: "{{ asset('weather') }}"
    };
</script>
<script src="{{ asset('js/geolocation.js') }}"></script>
