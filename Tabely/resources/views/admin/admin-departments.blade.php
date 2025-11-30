@php
    $selectedDep = null;
    if(session('selected_department_edit')) {
        $selectedDep = \App\Models\Department::find(session('selected_department_edit'));
    }
@endphp
<x-admin-layout>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center">
        <label class="text-4xl mt-12">All Departments: </label>
        @foreach($departments as $department)
            <x-department-index :active="session('selected_department_edit') == $department->id" :department="$department"></x-department-index>
        @endforeach
        <div class="w-full px-10">
            {{ $departments->links() }}
        </div>
    </div>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center">
        <form class="w-full h-full" method="POST" action="/admin/departments/update">
            @csrf
            @method('PATCH')
            <input id="dep_id" name="dep_id" type="hidden" value="{{ $selectedDep?->id }}" required>
            <div class="w-full flex flex-col px-10 gap-8 py-12">
                <label class="text-3xl">{{ $selectedDep?->dep_name ? $selectedDep->dep_name . ':' : 'Department:' }}</label>
                <input id="dep_name" name="dep_name" type="text" value="{{ $selectedDep?->dep_name ? $selectedDep->dep_name : '' }}" placeholder="Name" @disabled($selectedDep == null) class="text-center py-2 rounded-3xl bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70 hover:scale-95 transition-transform focus:scale-95">
                <label class="bg-white/70 text-center py-2 rounded-3xl text-gray-400">{{ $selectedDep?->id ? $selectedDep->id : 'ID' }}</label>
                <label class="bg-white/70 text-center py-2 rounded-3xl text-gray-400">{{ $selectedDep?->break_time_start ? date('H:i', strtotime($selectedDep->break_time_start)) : 'Start of the break time' }}</label>
                <label class="bg-white/70 text-center py-2 rounded-3xl text-gray-400">{{ $selectedDep?->break_time_end ? date('H:i', strtotime($selectedDep->break_time_end)) : 'End of the break time' }}</label>
                <label class="bg-white/70 text-center py-2 rounded-3xl text-gray-400">{{ $selectedDep?->cleaning_time_start ? date('H:i', strtotime($selectedDep->cleaning_time_start)) : 'Start of the cleaning time' }}</label>
                <label class="bg-white/70 text-center py-2 rounded-3xl text-gray-400">{{ $selectedDep?->cleaning_time_end ? date('H:i', strtotime($selectedDep->cleaning_time_end)) : 'End of the cleaning time' }}</label>
                <x-form-error name="dep_name"></x-form-error>
                <div class="flex flex-col">
                    <a href="/admin/departments/create" class="text-xs text-orange-500/70 hover:text-orange-600 active:text-orange-700 active:scale-95 transition-transform">Create New</a>
                    <button type="submit" @disabled($selectedDep == null) class="py-2 mx-20 rounded-3xl {{ $selectedDep == null ? 'bg-gray-200 text-gray-400' : 'bg-orange-500/70 text-white hover:bg-orange-600/70 active:bg-orange-700/70 hover:scale-95 active:scale-90 transition-transform' }} ">Save</button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>
