@php use App\Models\Department;use App\Models\Table;use App\Models\User; @endphp
@php
    $selectedTable = Table::find(session('selected_table_edit'));
@endphp
<x-admin-layout>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center">
        <div class="flex flex-col w-full items-center mt-12 gap-10">
            <label class="text-4xl">Tables</label>
            <div class="flex flex-col w-full items-center gap-2">
                <div class="w-[calc(75%)]">
                    <label>Select Department:</label>
                </div>
                <div class="relative w-[calc(80%)] hover:scale-95 transition-transform focus:scale-95">
                    <select id="department" name="department" style="text-align-last: center"
                            class="font-light block py-1 rounded-3xl w-full appearance-none bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70">
                        <option value="{{ $selectedDepartment == null ? '' : $selectedDepartment->id }}">{{ $selectedDepartment == null ? 'Select department' : $selectedDepartment->dep_name }}</option>
                        @foreach($departments as $department)
                            @continue($selectedDepartment !== null && $department->id == $selectedDepartment->id)
                            <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <img src="{{ asset('images/drop-arrow.png') }}" class="size-3" alt="dropdown menu arrow">
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col w-full gap-10 items-center">
            <label class="text-2xl">Tables:</label>
            @if(!empty($tables))
                @foreach($tables as $table)
                    <x-table-index :table="$table" :active="session('selected_table_edit') == $table->id"></x-table-index>
                @endforeach
                <div class="w-full px-10">
                    {{ $tables->links() }}
                </div>
            @endif
        </div>
    </div>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center">
        <form class="flex flex-col w-full items-center gap-10 mt-12" method="POST" action="/admin/tables/update">
            @csrf
            @method('PATCH')
            <label class="text-2xl">Picked Table:</label>
            <input
                id="desk_mac" name="desk_mac"
                @disabled(session('selected_table_edit') == null) value="{{ Table::find(session('selected_table_edit'))?->desk_mac }}"
                class="w-[calc(80%)] text-center py-2 rounded-3xl bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70 hover:scale-95 transition-transform focus:scale-95"
                placeholder="Desk Mac">
            <x-form-error name="desk_mac"></x-form-error>
            <label class="bg-white/70 text-center py-2 rounded-3xl text-gray-400 w-[calc(80%)]">{{ $groupedUsers == null ? 'ID' : 'ID: ' .Table::find(session('selected_table_edit'))?->id }}</label>
            <div class="relative w-[calc(80%)] hover:scale-95 transition-transform focus:scale-95">
                <select @disabled(session('selected_table_edit') == null) id="department_id" name="department_id"
                        style="text-align-last: center"
                        class="font-light block py-1 rounded-3xl w-full appearance-none bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70">
                    <option
                        value="{{ $selectedTable?->department_id }}">{{ Department::find($selectedTable?->department_id)?->dep_name ? Department::find($selectedTable?->department_id)?->dep_name : 'Select department' }}</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <img src="{{ asset('images/drop-arrow.png') }}" class="size-3" alt="dropdown menu arrow">
                </div>
                <x-form-error name="department_id"></x-form-error>
            </div>
            <div class="relative w-[calc(80%)] hover:scale-95 transition-transform focus:scale-95">
                <select @disabled(session('selected_table_edit') == null) id="user_id" name="user_id"
                        style="text-align-last: center"
                        class="font-light block py-1 rounded-3xl w-full appearance-none bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70">
                    <option value="">Select employee</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <img src="{{ asset('images/drop-arrow.png') }}" class="size-3" alt="dropdown menu arrow">
                </div>
            </div>
            <x-form-error name="user_id"></x-form-error>
            <div class="flex flex-col w-full items-center gap-2">
                <div class="w-[calc(75%)]">
                    <a href="/admin/tables/create" class="text-xs text-orange-500/70 hover:text-orange-600 active:text-orange-700 active:scale-95 transition-transform">Create New</a>
                </div>
                <button type="submit" @disabled($selectedTable == null) class="py-2 w-[calc(30%)] rounded-3xl {{ $selectedTable == null ? 'bg-gray-200 text-gray-400' : 'bg-orange-500/70 text-white hover:bg-orange-600/70 active:bg-orange-700/70 hover:scale-95 active:scale-90 transition-transform' }} ">Save</button>
            </div>
        </form>
    </div>
</x-admin-layout>
<script src="{{ asset('js/admin-tables.js') }}"></script>
<script>
    const groupedUsers = @json($groupedUsers);
    const selectedUserId = {{ $selectedTable?->user_id ?? 'null' }};
    const selectedDepartmentId = {{ $selectedTable?->department_id ?? 'null' }};
</script>
<script src="{{ asset('js/user-dropdown.js') }}"></script>
