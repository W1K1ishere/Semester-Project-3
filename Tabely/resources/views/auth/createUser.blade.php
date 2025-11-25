<x-login-layout>
    <form method="POST" action="/sendMail">
        @csrf
        <div class="flex flex-col gap-12 items-center">
            <div class="flex flex-col gap-4 items-center">
                <x-form-input id="email" name="email" required type="email" :value="old('email')" placeholder="Email"></x-form-input>
                <x-form-error name="email"></x-form-error>
                <script>
                    const tables = @json($tables);
                </script>
                <select id="department" name="department">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                    @endforeach
                </select>

                <select id="table" name="table">
                    <option value="">Select Table</option>
                </select>
                <script src="{{ asset('js/table-dropdown.js') }}"></script>
            </div>
            <div class="flex items-center gap-12">
                <button class="w-36 h-8 bg-white rounded-lg">Add User</button>
            </div>
        </div>
    </form>
</x-login-layout>
