@php
    $selectedDep = null;
    if(session('selected_department')) {
        $selectedDep = \App\Models\Department::find(session('selected_department'));
    }
@endphp
<x-admin-layout>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center py-12">
        <label class="text-4xl">
            Departments:
        </label>
        <div class="flex flex-col gap-5 w-full px-10">
            @foreach($departments as $department)
                <x-department-scheduler-button :active="session('selected_department') == $department->id" :department="$department"></x-department-scheduler-button>
            @endforeach
        </div>
        <div class="w-full px-10">
            {{ $departments->links() }}
        </div>
    </div>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center">
        {{--break time--}}
        <div class="flex flex-col items-center mt-12">
            <label class="text-3xl">Schedule New Break Time</label>
            <img src="{{ asset('images/break.png') }}" alt="coffee logo" class="size-12">
        </div>
        <div>
            <form method="POST" action="{{ route('scheduler.saveBreak') }}" class="flex flex-col gap-5">
                @csrf
                <div>
                    <input id="break_start" name="break_start" type="time" class="bg-black text-white rounded-3xl px-3 py-2" value="{{ $selectedDep?->break_time_start ? date('H:i', strtotime($selectedDep->break_time_start)) : '' }}">
                    <input id="break_end" name="break_end" type="time" class="bg-black text-white rounded-3xl px-3 py-2" value="{{ $selectedDep?->break_time_end ? date('H:i', strtotime($selectedDep->break_time_end)) : '' }}">
                </div>
                <button type="submit" class="bg-orange-500/70 text-white rounded-3xl px-3 py-2 hover:bg-orange-600/70 hover:scale-95 transition-transform active:bg-orange-700/70 active:scale-90">Save new break time</button>
            </form>
        </div>
        {{--cleaning time--}}
        <div class="flex flex-col items-center mt-10">
            <label class="text-3xl">Schedule New Cleaning Time</label>
            <img src="{{ asset('images/cleaning.png') }}" alt="broom" class="size-12">
        </div>
        <div>
            <form method="POST" action="{{ route('scheduler.saveBreak') }}" class="flex flex-col gap-5">
                @csrf
                <div>
                    <input id="break_start" name="break_start" type="time" class="bg-black text-white rounded-3xl px-3 py-2" value="{{ $selectedDep?->cleaning_time_start ? date('H:i', strtotime($selectedDep->break_time_start)) : '' }}">
                    <input id="break_end" name="break_end" type="time" class="bg-black text-white rounded-3xl px-3 py-2" value="{{ $selectedDep?->cleaning_time_end ? date('H:i', strtotime($selectedDep->break_time_end)) : '' }}">
                </div>
                <button type="submit" class="bg-orange-500/70 text-white rounded-3xl px-3 py-2 hover:bg-orange-600/70 hover:scale-95 transition-transform active:bg-orange-700/70 active:scale-90">Save new cleaning time</button>
            </form>
        </div>
    </div>
</x-admin-layout>
