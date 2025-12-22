@php use App\Models\Department;use App\Models\Table;use Illuminate\Support\Facades\Auth; @endphp
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
                <div class="relative w-72 h-72 mt-10 ml-32">
                    {{--avatar upload--}}
                    <form method="POST" action="/profile/update-avatar" enctype="multipart/form-data" class="absolute -right-16 -bottom-6">
                        @csrf
                        <label class="bg-white rounded-full cursor-pointer shadow active:scale-90 transition-transform block">
                            <input type="file" class="hidden" name="avatar" id="avatar">
                            <img src="{{ asset('images/upload.png') }}" class="size-20 px-4 py-4" alt="upload">
                        </label>
                    </form>

                    {{--avatar--}}
                    <img
                        @if($user->avatar)
                            src="{{ asset($user->avatar) }}"
                        @else
                            src="{{ asset('avatars/Default.jpg') }}"
                        @endif
                        class="rounded-full w-72 h-72 shadow-2xl" alt="profile picture">

                    {{--navigation back to welcome page--}}
                    <a href="/" class="absolute -top-6 -left-28 size-28 bg-white rounded-full p-1 shadow active:scale-90 transition-transform"><img src="{{ asset('images/logo.png') }}" alt="logo"></a>
                </div>


                {{--Edit profile text and small informations--}}
                <div class="flex flex-row">
                    <p class="font-bold text-2xl ml-12">My Profile</p>
                    {{--small info--}}
                    <div class="flex flex-col mt-5 ml-44">
                        <small class="text-gray-400">Created: {{ $user->created_at }}</small>
                        <small class="text-gray-400">Assigned
                            Tables: {{ Table::where('user_id', $user->id)->value('id') }}</small>
                        <small class="text-gray-400">Department: {{ $user->departments->pluck('dep_name')->join(', ') }}</small>
                    </div>
                </div>
                {{--user info--}}
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="flex flex-col gap-10 ml-11 mt-5">
                        {{--name and phone number--}}
                        <div class="flex flex-row gap-[54px]">
                            <x-profile-input id="name" name="name" type="text"
                                             value="{{ $user->name }}"></x-profile-input>
                            <x-profile-input id="phone" name="phone" type="text"
                                             value="{{ $user->phone }}"></x-profile-input>
                        </div>
                        {{--mail and height--}}
                        <div class="flex flex-row gap-10">
                            <x-profile-input id="email" name="email" type="email"
                                             value="{{ $user->email }}"></x-profile-input>
                            {{--height input with custom buttons--}}
                            <div>
                                <button type="button" onclick="this.nextElementSibling.stepDown()">−</button>
                                <x-profile-input id="height" name="height" type="number"
                                                 class="[&::-webkit-inner-spin-button]:appearance-none &::-webkit-outer-spin-button]:appearance-none] appearance-none"
                                                 value="{{ $user->height }}"></x-profile-input>
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
                <form id="send-form" method="POST" action="/send" class="hidden">
                    @csrf
                    <input id="email" name="email" type="email" value="{{ $user->mail }}">
                </form>
            </div>

            {{-- Right side profiles and edit profile option --}}
            <div class="flex-1 flex flex-col justify-between p-10">

                {{-- Profile picking menu --}}
                <div class="flex flex-col bg-orange-50/90 rounded-2xl gap-3.5 py-5 px-12 w-[700px] h-[350px]">
                    <!-- Top right content -->
                    <p class="text-4xl font-semibold mb-5">Profiles:</p>
                    @foreach($profiles as $profile)
                        <x-profiles-view :profile="$profile"
                                         :active="$profile->id===$user->picked_profile"></x-profiles-view>
                    @endforeach
                    <div class="mt-5">
                        {{ $profiles->links() }}
                    </div>
                </div>

                {{-- Edit profile --}}
                    <!-- Bottom right content -->
                    <div class="flex flex-row bg-orange-50/90 rounded-2xl py-5 px-12 w-[700px] h-[430px] gap-32 ">
                        <div class="flex flex-col gap-6 h-full">
                            <form class="flex flex-col gap-6 h-full" method="POST" action="{{ route('profile.save') }}">
                                @csrf
                                @method('PATCH')
                            <!-- profile name -->
                            <p class="text-4xl font-semibold">{{ $activeProfile->name }} :</p>
                            {{--standing height input--}}
                            <x-profile-edit-input id="standing_height" name="standing_height" text="Standing height: "
                                                  :value="$activeProfile->standing_height"></x-profile-edit-input>
                            {{--sitting height input--}}
                            <x-profile-edit-input id="sitting_height" name="sitting_height" text="Sitting height: "
                                                  :value="$activeProfile->sitting_height"></x-profile-edit-input>
                            {{--Session length--}}
                            <x-profile-edit-input id="session_length" name="session_length" text="Session length: "
                                                  :value="$activeProfile->session_length"></x-profile-edit-input>
                            <x-form-error name="session_length"></x-form-error>
                            {{--save, cancle, delete buttons--}}
                            <div class="flex flex-row gap-5">
                                <button type="submit" class="bg-orange-500 px-3 py-2 rounded-2xl ">Save</button>
                                <button type="submit" form="delete-form" class="bg-transparent text-orange-500">Delete
                                </button>
                                <a class="bg-transparent text-black mt-2" href="/profile/cancel">Cancel</a>
                            </div>
                            </form>
                        </div>
                        <div class="flex flex-col gap-6 h-full items-center">
                            <form method="POST" action="/profile/create" class="flex flex-col gap-6 h-full items-center">
                                @csrf
                            <!--name input-->
                            <input name="name" id="name" type="text" placeholder="Name" class="pt-3 bg-transparent border-b-black border-b-2 text-center text-black">
                            {{--standing height input--}}
                            <x-profile-edit-input id="standing_height" name="standing_height" text="Standing height: " :value="0"></x-profile-edit-input>
                            {{--sitting height input--}}
                            <x-profile-edit-input id="sitting_height" name="sitting_height" text="Sitting height: " :value="0"></x-profile-edit-input>
                            {{--Session length--}}
                            <x-profile-edit-input id="session_length" name="session_length" text="Session length: " :value="0"></x-profile-edit-input>
                            <x-form-error name="session_length"></x-form-error>
                            {{--create button--}}
                            <button type="submit" class="bg-orange-500 px-3 py-2 rounded-2xl">Create new profile</button>
                            </form>
                        </div>
                    </div>
                <form id="delete-form" method="POST" action="/profile/delete" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>

    </div>
</div>
</body>
</html>
<script src="{{ asset('js/avatar.js') }}"></script>
