<x-admin-layout>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center">
        <label class="text-4xl mt-12">All Departments: </label>
        @foreach($departments as $department)
            <div class="flex flex-col  w-[calc(66%)] rounded-3xl py-1 px-2 items-center gap-1 bg-white/70">
                <label class="text-black py-2">{{ $department->dep_name }} <small>ID: {{ $department->id }}</small></label>
            </div>
        @endforeach
        <div class="w-full px-10">
            {{ $departments->links() }}
        </div>
    </div>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center">
        <form class="w-full h-full" method="POST" action="/admin/departments/create/create">
            @csrf
            <div class="w-full flex flex-col px-10 gap-8 py-14 items-center">
                <label class="text-2xl">Create department:</label>
                <input id="dep_name" name="dep_name" type="text" required placeholder="Department name" class="text-center py-2 rounded-3xl bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70 hover:scale-95 transition-transform focus:scale-95">
                <x-form-error name="dep_name"></x-form-error>
                <div class="flex flex-col items-center">
                    <div class="flex flex-col items-center ">
                        <label class="text-3xl">Set Break Time</label>
                        <img src="{{ asset('images/break.png') }}" alt="coffee cup" class="size-12">
                    </div>
                    <div class="flex flex-row items-center mt-5 gap-2">
                        <input id="break_start" name="break_start" type="time" required class="bg-black text-white rounded-3xl px-3 py-2">
                        <input id="break_end" name="break_end" type="time" required class="bg-black text-white rounded-3xl px-3 py-2">
                    </div>
                </div>
                <x-form-error name="break_star"></x-form-error>
                <x-form-error name="break_end"></x-form-error>
                <div class="flex flex-col items-center">
                    <div class="flex flex-col items-center">
                        <label class="text-3xl">Set Cleaning Time</label>
                        <img src="{{ asset('images/cleaning.png') }}" alt="broom" class="size-12">
                    </div>
                    <div class="flex flex-row items-center mt-5 gap-2">
                        <input id="cleaning_star" name="break_start" type="time" required class="bg-black text-white rounded-3xl px-3 py-2">
                        <input id="cleaning_end" name="break_end" type="time" required class="bg-black text-white rounded-3xl px-3 py-2">
                    </div>
                </div>
                <x-form-error name="cleaning_star"></x-form-error>
                <x-form-error name="cleaning_end"></x-form-error>
                <button type="submit" class="w-[calc(40%)] bg-orange-500/70 text-white rounded-3xl px-3 py-2 hover:bg-orange-600/70 hover:scale-95 transition-transform active:bg-orange-700/70 active:scale-90">Create</button>
            </div>
        </form>
    </div>
</x-admin-layout>
