@php use Illuminate\Support\Facades\Auth; @endphp
<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>
    <link rel="icon" type="image/png" href="{{ asset('icons/icon.png') }}" class="rounded-lg">
    <link rel="stylesheet" href="{{ asset('css/navLink.css') }}">
    <link rel="stylesheet" href="{{ asset('css/model3D.css') }}">

</head>
<body class="h-full w-full">
    <div class="min-h-full w-full">
        {{--navigation bar--}}
        <nav class="bg-white px-4 py-4 border-2">
            <div class="flex h-12 items-center justify-between">
                {{--left side--}}
                <div class="flex items-center gap-4">
                    {{--Logo--}}
                    <div class="flex shrink-0 items-center hover:scale-95 transition-transform active:scale-90">
                        <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="size-16">
                        <a href="/" class="font-bold text-2xl">
                            Tabely
                        </a>
                    </div>
                    {{--links--}}
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="/home" class="link">
                                <span class="splitUp {{ request()->is('home') ? 'text-orange-600' : '' }}">Home</span>
                                <span class="splitDown">Home</span>
                            </a>
                            <a href="/condition" class="link">
                                <span class="splitUp {{ request()->is('condition') ? 'text-orange-600' : '' }}">Conditions</span>
                                <span class="splitDown">Conditions</span>
                            </a>
                        @endauth
                        <a href="/features" class="link">
                            <span class="splitUp {{ request()->is('features') ? 'text-orange-600' : '' }}">Features</span>
                            <span class="splitDown">Features</span>
                        </a>
                        <a href="/companies" class="link">
                            <span class="splitUp {{ request()->is('companies') ? 'text-orange-600' : '' }}">Companies</span>
                            <span class="splitDown">Companies</span>
                        </a>
                        <a href="/support" class="link">
                            <span class="splitUp {{ request()->is('support') ? 'text-orange-600' : '' }}">Support</span>
                            <span class="splitDown">Support</span>
                        </a>
                    </div>
                </div>
                {{--login button--}}
                <div class="flex gap-4 pb-0.5">
                    @auth
                        <div class="pt-1.5 flex flex-row gap-4">
                            @if(Auth::user()->isAdmin)
                                <a id="adminLink" name="adminLink" href="/admin" class="link">
                                    <span class="splitUp">Admin</span>
                                    <span class="splitDown">Admin</span>
                                </a>
                            @endif
                            <a href="/profile/{{ auth()->user() }}" class="link">
                                <span class="splitUp">Profile</span>
                                <span class="splitDown">Profile</span>
                            </a>
                        </div>
                        <div>
                            <form method="POST" action="/logout">
                                @csrf
                                <button class="bg-black text-white px-4 py-2 w-24 text-center rounded-xl hover:bg-gray-900 hover:scale-95 transition-transform active:scale-90 active:bg-gray-700" type="submit">Log Out</button>
                            </form>
                        </div>

                    @endauth
                </div>
            </div>
        </nav>
        <script src="{{ asset('js/spanText.js') }}?v={{ filemtime(public_path('js/spanText.js')) }}"></script>
        {{--body--}}
        <div class="w-full">
            {{ $slot }}
        </div>
        {{--footer--}}
        <footer class="px-20 py-16 bg-white border-2">
            <div class="flex flex-row justify-between">
                {{--left side - Logo, p, links to social media--}}
                <div class="flex flex-col gap-3 items-start mt-2">
                    <h2 class="font-bold text-2xl">Tabely &reg;</h2>
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
