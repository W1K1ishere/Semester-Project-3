@props(['currentCondition'])

<div class="relative bg-orange-50 w-[calc(100%-200px)] h-[150px] mt-10 rounded-3xl overflow-hidden shadow-2xl">
    <div class="relative flex flex-row rounded-3xl justify-between z-30 px-10 pt-8">
        <div class="flex flex-row items-center">
            <label class="text-4xl text-amber-700">{{ $currentCondition->department }}</label>
            <img src="{{ asset('images/department.png') }}" alt="department" class="size-16">
        </div>
        <div class="flex flex-row items-center">
            <label class="text-4xl text-amber-700">{{ $currentCondition->temperature }}°C</label>
            <img src="{{ asset('images/temperature.png') }}" alt="temperature" class="size-16">
        </div>
        <div class="flex flex-row items-center">
            <label class="text-4xl text-amber-700">{{ $currentCondition->humidity }}%</label>
            <img src="{{ asset('images/humidity.png') }}" alt="humidity" class="size-16">
        </div>
        <div class="flex flex-row items-center gap-3">
            <label class="text-4xl text-amber-700">Condition: </label>
            @if($currentCondition->temperature >= 21.0 && $currentCondition->temperature <= 24 && $currentCondition->humidity >=40 && $currentCondition->humidity <= 60)
            <label class="text-4xl text-green-500">GOOD</label>
            @elseif($currentCondition->temperature >= 18.0 && $currentCondition->temperature <= 27 && $currentCondition->humidity >=30 && $currentCondition->humidity <= 70 )
            <label class="text-4xl text-yellow-500">AVERAGE</label>
            @else
            <label class="text-4xl text-red-500">BAD</label>
            @endif

        </div>
    </div>
</div>
