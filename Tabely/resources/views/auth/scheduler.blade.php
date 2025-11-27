@php use App\Models\Department; @endphp
<x-layout>
    @php
        $selectedDep = null;
        if(session('selected_department')) {
            $selectedDep = \App\Models\Department::find(session('selected_department'));
        }
    @endphp
    <div class="flex flex-row h-screen">
        {{--side bar menu--}}
        <div class="w-1/4  h-full ">
            <div class="h-[calc(100%-50px)] rounded-3xl bg-gray-200 py-5 px-5 mx-3 my-5 flex flex-col justify-center gap-3">
                @foreach($departments as $department)
                    <x-department-button :active="session('selected_department') == $department->id" :department="$department"></x-department-button>
                @endforeach
                <div class="mt-5">
                    {{ $departments->links() }}
                </div>
            </div>
        </div>

        {{--break side--}}
        <div class="flex-1 flex flex-col justify-center items-center">
            {{--headline--}}
            <div class="flex flex-row w-full gap-2 items-center justify-center mb-4">
                <img src="{{ asset('images/break.png') }}" alt="coffee logo" class="size-12">
                <p class="text-4xl">Schedule Break</p>
            </div>
            {{--input--}}
            <div class="flex flex-col items-center gap-4">
                <form class="flex flex-col gap-4 items-center" method="POST" action="{{ route('scheduler.saveBreak') }}">
                    @csrf
                    <div class="flex flex-row gap-4">
                        <input id="break_start" name="break_start" type="time" class="bg-black text-white rounded-3xl px-3 py-2" value="{{ $selectedDep?->break_time_start ? date('H:i', strtotime($selectedDep->break_time_start)) : '' }}">
                        <input id="break_end" name="break_end" type="time" class="bg-black text-white rounded-3xl px-3 py-2" value="{{ $selectedDep?->break_time_end ? date('H:i', strtotime($selectedDep->break_time_end)) : '' }}">
                    </div>
                    <button type="submit" class="bg-orange-500 text-white rounded-3xl px-3 py-2">Save New Break Time</button>
                </form>
            </div>
        </div>

        {{--separating line--}}
        <div class="w-0.5 rounded-2xl bg-gray-300 h-full"></div>

        {{--cleaning side--}}
        <div class="flex-1 flex flex-col justify-center items-center">
            {{--headline--}}
            <div class="flex flex-row gap-2 items-center mb-4">
                <img src="{{ asset('images/cleaning.png') }}" alt="coffee logo" class="size-12">
                <p class="text-4xl">Schedule Cleaning</p>
            </div>
            {{--input--}}
            <div class="flex flex-col items-center gap-4">
                <form class="flex flex-col gap-4 items-center" method="POST" action="{{ route('scheduler.saveCleaning') }}">
                    @csrf
                    <div class="flex flex-row gap-4">
                        <input id="cleaning_start" name="cleaning_start" type="time" class="bg-black text-white rounded-3xl px-3 py-2" value="{{ $selectedDep?->cleaning_time_start ? date('H:i', strtotime($selectedDep->cleaning_time_start)) : '' }}">
                        <input id="cleaning_end" name="cleaning_end" type="time" class="bg-black text-white rounded-3xl px-3 py-2" value="{{ $selectedDep?->cleaning_time_end ? date('H:i', strtotime($selectedDep->cleaning_time_end)) : '' }}">
                    </div>
                    <button type="submit" class="bg-orange-500 text-white rounded-3xl px-3 py-2">Save New Cleaning Time</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
