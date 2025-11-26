@props(['active' => false, 'profile'])
<form method="POST" action="{{ route('profile.select') }}">
    @csrf
    <input type="hidden" name="profile_id" value="{{ $profile->id }}">
    <button type="submit" class="flex flex-row items-center gap-5 {{ $active ? "text-white bg-orange-400" : "text-black bg-gray-300" }} px-5 py-1.5 rounded-2xl hover:bg-gray-200 font-semibold text-xl">
        {{ $profile->name }}
        <p class="text-black text-xs">Standing height : {{ $profile->standing_height }} cm</p>
        <p class="text-black text-xs">Sitting height : {{ $profile->sitting_height }} cm</p>
        <p class="text-black text-xs">Session length : {{$profile->session_length}} min</p>
    </button>
</form>
