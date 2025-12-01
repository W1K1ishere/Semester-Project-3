@php use App\Models\Department;use App\Models\Table;use App\Models\User; @endphp
<x-admin-layout>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center">
        <div class="flex flex-col w-full items-center mt-12 gap-10">
            <label class="text-4xl">Tables</label>
            <div class="flex flex-col w-full items-center gap-2">
                <div class="w-[calc(75%)]">
                    <label>Select Department:</label>
                </div>
                <div class="relative w-[calc(80%)] hover:scale-95 transition-transform focus:scale-95">
                    <select id="department_create" name="department_create" style="text-align-last: center"
                            class="font-light block py-1 rounded-3xl w-full appearance-none bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70">
                        <option value="">Select department</option>
                        @foreach($departments as $department)
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
                    <label class="bg-white/70 py-3 w-[calc(60%)] text-center rounded-3xl">{{ $table->desk_mac }} <small>ID: {{ $table->id }}</small></label>
                @endforeach
                <div class="w-full px-10">
                    {{ $tables->links() }}
                </div>
            @endif
        </div>
    </div>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center">
        <form class="flex flex-col w-full items-center gap-10 mt-14" method="POST" action="/admin/tables/create/create">
            @csrf
            <label class="text-2xl">Create Table:</label>
            <div class="relative w-[calc(80%)] hover:scale-95 transition-transform focus:scale-95">
                <select id="dep_id" name="dep_id" style="text-align-last: center"
                        class="font-light block py-1 rounded-3xl w-full appearance-none bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70">
                    <option value="">Select department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <img src="{{ asset('images/drop-arrow.png') }}" class="size-3" alt="dropdown menu arrow">
                </div>
            </div>
            <input id="desk_mac" name="desk_mac" class="w-[calc(80%)] text-center py-2 rounded-3xl bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70 hover:scale-95 transition-transform focus:scale-95" placeholder="Desk Mac">
            <x-form-error name="desk_mac"></x-form-error>
            <button type="submit" class="py-2 w-[calc(30%)] rounded-3xl bg-orange-500/70 text-white hover:bg-orange-600/70 active:bg-orange-700/70 hover:scale-95 active:scale-90 transition-transform">Save</button>
        </form>
    </div>
</x-admin-layout>
<script src="{{ asset('js/admin-tables.create.js') }}"></script>
