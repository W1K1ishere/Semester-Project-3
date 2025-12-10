<x-admin-layout>
    <div class="flex flex-col bg-orange-50/90 w-[calc(66.6%)] rounded-2xl gap-10 items-center py-12">
        <label class="text-4xl">Add new user to system</label>
        <form method="POST" action="/sendMail" class="w-full flex justify-center">
            @csrf
            <div class="flex flex-col gap-10 w-[calc(40%)]">
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="Email" class="text-center py-2 rounded-3xl bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70 hover:scale-95 transition-transform focus:scale-95">
                <x-form-error name="email"></x-form-error>
                <script>
                    window.tables = @json($tables);
                </script>
                <div class="relative w-full hover:scale-95 transition-transform focus:scale-95">
                    <select id="department" name="department" style="text-align-last: center" class="font-light block py-1 rounded-3xl w-full appearance-none bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70">
                        <option value="">Select department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <img src="{{ asset('images/drop-arrow.png') }}" class="size-3" alt="dropdown menu arrow">
                    </div>
                    <x-form-error name="department"></x-form-error>
                </div>
                <div class="relative w-full hover:scale-95 transition-transform focus:scale-95">
                    <select id="table" name="table" style="text-align-last: center" class="form-control font-light block py-1 rounded-3xl w-full appearance-none bg-white/80 focus:outline-none focus:ring-orange-500/70 focus:ring-2 focus:bg-gray-200/70 hover:bg-gray-100/70">
                        <option value="" >Select table</option>
                        @foreach($tables as $departmentId => $group)
                            <optgroup label="Department {{ $departmentId }}">
                                @foreach($group as $table)
                                    <option value="{{ $table->id }}">
                                        {{ $table->desk_mac }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                        <img src="{{ asset('images/drop-arrow.png') }}" class="size-3" alt="dropdown menu arrow">
                    </div>
                    <x-form-error name="table"></x-form-error>
                </div>
                <script src="{{ asset('js/table-dropdown.js') }}"></script>
                <button type="submit" class="bg-orange-500/70 text-white rounded-3xl px-3 py-2 hover:bg-orange-600/70 hover:scale-95 transition-transform active:bg-orange-700/70 active:scale-90">Add New User</button>
            </div>
        </form>
    </div>
</x-admin-layout>
