@php use App\Models\User; @endphp
@php
    $selectedUser = User::find(session('selected_user_edit'));
@endphp
<x-admin-layout>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center">
        <div class="flex flex-col w-full items-center mt-12 gap-10">
            <label class="text-4xl">Employees</label>
            <div class="flex flex-col w-full items-center gap-2">
                <div class="w-[calc(75%)]">
                    <label>Select Department:</label>
                </div>
                <div class="relative w-[calc(80%)] hover:scale-95 transition-transform focus:scale-95">
                    <select id="department_users" name="department_users" style="text-align-last: center"
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
                    <script src="{{ asset('js/admin-users.js') }}"></script>
                </div>
            </div>
        </div>
        <div class="flex flex-col w-full gap-10 items-center">
            <label class="text-2xl">Employees:</label>
            @if(!empty($users))
                @foreach($users as $user)
                    <x-user-index :user="$user" :active="session('selected_user_edit') == $user->id"></x-user-index>
                @endforeach
                <div class="w-full px-10">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center pt-12">
        <label class="text-2xl">Employee:</label>
        <form class="items-center w-full h-full">
        <div class="w-full flex flex-col gap-10 items-center">
            <label class="bg-white/70 text-center py-2 rounded-3xl text-gray-400 w-[calc(80%)]">{{ session('selected_user_edit') == null ? 'ID' : User::find(session('selected_user_edit'))?->id }}</label>
            <label class="bg-white/70 text-center py-2 rounded-3xl text-gray-400 w-[calc(80%)]">{{ session('selected_user_edit') == null ? 'Name' : User::find(session('selected_user_edit'))?->name }}</label>
            <label class="bg-white/70 text-center py-2 rounded-3xl text-gray-400 w-[calc(80%)]">{{ session('selected_user_edit') == null ? 'Email' : User::find(session('selected_user_edit'))?->email }}</label>
            <label class="bg-white/70 text-center py-2 rounded-3xl text-gray-400 w-[calc(80%)]">{{ session('selected_user_edit') == null ? 'Phone' : User::find(session('selected_user_edit'))?->phone }}</label>
        </div>
        </form>
    </div>
</x-admin-layout>
