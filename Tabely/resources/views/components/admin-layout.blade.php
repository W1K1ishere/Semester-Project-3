<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <link rel="icon" type="image/png" href="{{ asset('icons/icon.png') }}">
</head>
    <body class="min-h-screen m-0 bg-cover bg-center bg-no-repeat flex justify-center"
          style="background-image: url('{{ asset('images/profile-background.jpg') }}');">
        {{-- Outer wrapper with top/bottom margin --}}
        <div class="flex justify-center w-full my-10">

            {{-- Transparent floating background --}}
            <div class="rounded-2xl bg-white/40 w-[calc(100%-50px)] h-full flex flex-col items-center justify-center">

                {{-- Left and right side --}}
                <div class="flex flex-row w-[calc(100%-70px)] h-[calc(100%-70px)] gap-5">
                    {{--side bar--}}
                    <div class="flex flex-col bg-orange-50/90 w-[calc(33%-10px)] rounded-2xl gap-10 items-center">
                        <a href="/" class="mt-10 flex flex-col items-center">
                            <label class="text-6xl font-bold "> Tabely </label>
                            <img src="{{ asset('images/logo.png') }}" alt="logo" class="size-32">
                        </a>
                        <div class="flex flex-col gap-5 w-full px-10">
                            <x-admin-menu-link href="/admin/departments" :active="request()->is('admin/departments*')">Departments</x-admin-menu-link>
                            <x-admin-menu-link href="/admin/scheduler" :active="request()->is('admin/scheduler')">Scheduler</x-admin-menu-link>
                            <x-admin-menu-link href="/admin/addUser" :active="request()->is('admin/addUser')">Add User</x-admin-menu-link>
                            <x-admin-menu-link href="/admin/tables" :active="request()->is('admin/tables*')">Tables</x-admin-menu-link>
                            <x-admin-menu-link href="/admin/users" :active="request()->is('admin/users*')">Users</x-admin-menu-link>
                        </div>
                    </div>
                    {{--content--}}
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
