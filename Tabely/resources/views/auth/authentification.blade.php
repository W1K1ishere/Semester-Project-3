<x-login-layout>
    <form method="POST" action="/login">
        @csrf
        <div class="flex flex-col gap-12 items-center">
            <div class="flex flex-col gap-4 items-center">
                <x-form-input id="code" name="code" required type="text" placeholder="Code"></x-form-input>
                <x-form-error name="code"></x-form-error>
            </div>
            <div class="flex items-center gap-12">
                <button class="w-36 h-8 bg-white rounded-lg">Login</button>
            </div>
        </div>
    </form>
</x-login-layout>
