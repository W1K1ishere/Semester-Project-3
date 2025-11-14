<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full m-0">

<div class="pb-56 flex flex-col items-center justify-center h-screen w-screen bg-cover bg-center bg-no-repeat bg-[url('{{ asset('images/login-office.jpg') }}')]">

    {{-- Logo + Title --}}
    <div class="flex flex-col items-center">
        <a href="/" class="text-black text-8xl font-bold opacity-80">Tabely</a>
        <a href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-48 h-48 opacity-85">
        </a>
    </div>

    {{-- Form --}}
    <form method="POST" action="/reset">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="flex flex-col gap-12 items-center">
            <div class="flex flex-col gap-4 items-center">
                <x-form-input id="password" name="password" required type="password" placeholder="Password"></x-form-input>
                <x-form-input id="password_confirmation" name="password_confirmation" required type="password" placeholder="Confirm Password"></x-form-input>
                <x-form-error name="password"></x-form-error>
            </div>
            <div class="flex items-center gap-12">
                <button class="w-36 h-8 bg-white rounded-lg">Reset Password</button>
            </div>
        </div>
    </form>

</div>

</body>
</html>
