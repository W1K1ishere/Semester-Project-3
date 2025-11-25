@php use Illuminate\Support\Facades\Auth; @endphp
<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <link rel="icon" type="image/png" href="{{ asset('icons/icon.png') }}" class="rounded-lg">

</head>
<body class="h-full w-full">
    <div class="min-h-full w-full">
        {{--navigation bar--}}
        <nav class="bg-white px-4 py-4 border-2">
            <div class="flex h-12 items-center justify-between">
                {{--left side--}}
                <div class="flex items-center gap-4">
                    {{--Logo--}}
                    <div class="flex shrink-0 items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="size-16">
                        <a href="/" class="font-bold text-2xl">
                            Tabely
                        </a>
                    </div>
                    {{--links--}}
                    <div class="flex items-center gap-3">
                        @auth
                            <x-nav-link>Home</x-nav-link>
                            <x-nav-link>Charts</x-nav-link>
                        @endauth
                        <x-nav-link href="/features" :active="request()->is('features')" >Features</x-nav-link>
                        <x-nav-link href="/companies" :active="request()->is('companies')">For Companies</x-nav-link>
                        <x-nav-link href="/support" :active="request()->is('support')">Support</x-nav-link>
                    </div>
                </div>
                {{--login button--}}
                <div class="flex gap-0.5 pb-0.5">
                    @auth
                        <div class="pt-1.5">
                            @if(Auth::user()->isAdmin)
                                <a href="/createUser" class="text-center text-xs text-orange-500 hover:bg-gray-200 rounded-md px-3 py-2">
                                    Create New User
                                </a>
                            @endif
                            @if(Auth::user()->isAdmin)
                                <a href="/scheduler" class="text-center text-xs text-orange-500 hover:bg-gray-200 rounded-md px-3 py-2">
                                    Scheduler
                                </a>
                            @endif
                            <x-nav-link href="/profile/{{ auth()->user() }}">Edit Profile</x-nav-link>
                        </div>
                        <div>
                            <form method="POST" action="/logout">
                                @csrf
                                <button class="bg-black text-white px-4 py-2 w-24 text-center rounded-xl" type="submit">Log Out</button>
                            </form>
                        </div>

                    @endauth
                </div>
            </div>
        </nav>
        {{--body--}}
        <div class="w-full">
            {{ $slot }}
        </div>
        {{--footer--}}
        <footer class="px-20 py-16 bg-white border-2">
            <div class="flex flex-row justify-between">
                {{--left side - Logo, p, links to social media--}}
                <div class="flex flex-col gap-3 items-start mt-2">
                    <h2 class="font-bold text-2xl">Tabely</h2>
                    <p class="text-xs text-gray-400">Software for easy control of adjustable tables in your company</p>
                    {{--social media links--}}
                    <div class="flex gap-2 mt-4">
                        <x-social-link href="https://instagram.com" src="images/ig.png" alt="Instagram"></x-social-link>
                        <x-social-link href="https://facebook.com" src="images/fb.png" alt="Facebook"></x-social-link>
                        <x-social-link href="https://x.com" src="images/x.png" alt="X"></x-social-link>
                    </div>
                </div>
                {{--right side--}}
                <div class="flex flex-row gap-14">
                    {{--first row--}}
                    <div class="flex flex-col gap-2">
                        <a>Features</a>
                        <a class="text-sm opacity-50">Core features</a>
                        <a class="text-sm opacity-50">Integrations</a>
                    </div>
                    {{--second row--}}
                    <div class="flex flex-col gap-2">
                        <a>For Companies</a>
                        <a class="text-sm opacity-50">Blog</a>
                        <a class="text-sm opacity-50">Customer stories</a>
                    </div>
                    {{--third row--}}
                    <div class="flex flex-col gap-2">
                        <a>Support</a>
                        <a class="text-sm opacity-50">Contact</a>
                        <a class="text-sm opacity-50">Support</a>
                        <a class="text-sm opacity-50">Legal</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
