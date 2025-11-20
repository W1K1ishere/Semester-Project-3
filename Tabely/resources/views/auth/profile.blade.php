@php use Illuminate\Support\Facades\Auth; @endphp
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
        <div class="rounded-2xl bg-white/40 w-[1350px] h-[900px] flex flex-col items-center justify-center">

            {{-- Left and right side --}}
            <div class="flex flex-row w-full h-full ">

                {{-- Left side profile info --}}
                <div class="flex flex-col bg-orange-50/90 w-[550px] rounded-2xl my-10 ml-10 gap-10">
                    <!-- Left content -->
                    <img src="{{asset('avatars/Default.jpg')}}" alt="Profile picture" class="rounded-full w-72 h-72 mt-10 ml-32">
                    {{--Edit profile text and small informations--}}
                    <div class="flex flex-row">
                        <p class="font-bold text-2xl ml-12">My Profile</p>
                        {{--small info--}}
                        <div class="flex flex-col mt-5 ml-44">
                            <small class="text-gray-400">Created: {{ $user->created_at }}</small>
                            <small class="text-gray-400">Assigned Tables: </small>
                            <small class="text-gray-400">Department: </small>
                        </div>
                    </div>
                    {{--user info--}}
                    <form method="POST" action="/update">
                        <div class="flex flex-col gap-10 ml-11 mt-5">
                            {{--name and phone number--}}
                            <div class="flex flex-row gap-[54px]">
                                <x-profile-input id="name" name="name" type="text" value="{{ $user->name }}"></x-profile-input>
                                <x-profile-input id="phone" name="phone" type="text" value="{{ $user->phone }}"></x-profile-input>
                            </div>
                            {{--mail and height--}}
                            <div class="flex flex-row gap-10">
                                <x-profile-input id="email" name="email" type="email" value="{{ $user->email }}"></x-profile-input>
                                {{--height input with custom buttons--}}
                                <div>
                                    <button type="button" onclick="this.nextElementSibling.stepDown()">−</button>
                                    <x-profile-input id="height" name="height" type="number" class="[&::-webkit-inner-spin-button]:appearance-none &::-webkit-outer-spin-button]:appearance-none] appearance-none" value="{{ $user->height }}"></x-profile-input>
                                    <button type="button" onclick="this.previousElementSibling.stepUp()">+</button>
                                </div>
                            </div>
                        </div>
                        {{--password reset button and save button--}}
                        <div class="flex flex-col mt-8 gap-14">
                            <button form="send-form" class="text-orange-400 mr-[345px]">Reset password</button>
                            <button type="submit" class="bg-orange-400 rounded-2xl w-40 h-12 ml-48">Save</button>
                        </div>
                    </form>
                </div>

                {{-- Right side profiles and edit profile option --}}
                <div class="flex-1 flex flex-col justify-between p-10">

                    {{-- Profile picking menu --}}
                    <div class="flex flex-col bg-orange-50/90 rounded-2xl gap-3 py-5 px-3 w-[700px] h-[350px]">
                        <!-- Top right content -->
                        @foreach($profiles as $profile)
                            <x-profiles-view :profile="$profile" :active="$profile->id===$user->picked_profile"></x-profiles-view>
                        @endforeach
                        <div class="mt-4">
                            {{ $profiles->links() }}
                        </div>
                    </div>

                    {{-- Edit profile --}}
                    <div class="flex flex-col bg-orange-50/90 rounded-2xl">
                        <!-- Bottom right content -->
                    </div>

                </div>
            </div>

        </div>
    </div>

    <form id="send-form" method="POST" action="/send" class="hidden">
        @csrf
        @method('send')
        <input id="reset_mail" name="reset_mail" value="{{ $user->mail }}">
    </form>
</body>
</html>
