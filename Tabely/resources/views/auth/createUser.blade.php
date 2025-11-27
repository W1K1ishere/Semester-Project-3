<x-login-layout>
    <form method="POST" action="/sendMail">
        @csrf
        <div class="flex flex-col gap-12 items-center">
            <div class="flex flex-col gap-4 items-center">
                <x-form-input id="email" name="email" required type="email" :value="old('email')" placeholder="Email"></x-form-input>
                <x-form-error name="email"></x-form-error>

                <select id="department" name="department">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                    @endforeach
                </select>

                <select id="table" name="table">
                    <option value="">Select Table</option>
                </select>
            </div>

            <div class="flex items-center gap-12">
                <button class="w-36 h-8 bg-white rounded-lg">Add User</button>
            </div>
        </div>
    </form>




<script>
document.addEventListener("DOMContentLoaded", async () => {
    const dropdown = document.getElementById("table");

    try {
        const response = await fetch("/proxy/desks");

        const json = await response.json();

        const desks = json.desks ?? json;

        dropdown.innerHTML = '<option value="">Select Table</option>';

        desks.forEach(desk => {
            // desk is just a string, like "cd:fb:1a:53:fb:e6"
            const desk_id = desk;

            const option = document.createElement("option");
            option.value = desk_id;
            option.textContent = desk_id; 

            dropdown.appendChild(option);
        });

    } catch (err) {
        console.error("🚨 Fetch error:", err);
    }
});


</script>



</x-login-layout>
