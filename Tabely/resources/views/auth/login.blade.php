<x-login-layout>
    <form method="POST" action="/send-code">
        @csrf
        <div class="flex flex-col gap-12 items-center">
            <div class="flex flex-col gap-4 items-center">
                <x-form-input id="email" name="email" required type="email" :value="old('email')" placeholder="Email"></x-form-input>
                <x-form-error name="email"></x-form-error>
                <x-form-input id="password" name="password" required type="password" placeholder="Password"></x-form-input>
                <x-form-error name="password"></x-form-error>
            </div>
            <div class="flex items-center gap-12">
                <button class="w-36 h-8 bg-white rounded-lg">Login</button>
                <a href="/reset-request" class="p-0.5 border-2 border-black w-36 h-8 rounded-lg text-center bg-white/20">Reset Password</a>
            </div>
        </div>
    </form>
</x-login-layout>
