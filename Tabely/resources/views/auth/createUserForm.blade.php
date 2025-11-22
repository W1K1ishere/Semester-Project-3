<x-login-layout>
    <form method="POST" action="/createNewUser">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="flex flex-col gap-12 items-center">
            <div class="flex flex-col gap-4 items-center">
                <x-form-input id="email" name="email" required type="email" value="{{ $email }}" disabled></x-form-input>
                <x-form-input id="name" name="name" required type="string" :value="old('name')" placeholder="Name"></x-form-input>
                <x-form-input id="height" name="height" required type="number" :value="old('height')" placeholder="Height"></x-form-input>
                <x-form-input id="phone" name="phone" required type="string" :value="old('phone')" placeholder="Phone number"></x-form-input>
                <x-form-input id="password" name="password" required type="password" placeholder="Password"></x-form-input>
                <x-form-input id="password_confirmation" name="password_confirmation" required type="password" placeholder="Confirm Password"></x-form-input>
                <x-form-error name="password"></x-form-error>
            </div>
            <div class="flex items-center gap-12">
                <button type="submit" class="w-36 h-8 bg-white rounded-lg">Create Profile</button>
            </div>
        </div>
    </form>
</x-login-layout>
