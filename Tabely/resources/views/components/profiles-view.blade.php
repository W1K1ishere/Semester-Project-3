@props(['active' => false, 'profile'])
<form method="POST" action="{{ route('profile.select') }}">
    @csrf
    <input type="hidden" name="profile_id" value="{{ $profile->id }}">
    <button type="submit" class="flex flex-row items-center gap-5 {{ $active ? "text-white bg-orange-500/70" : "text-white bg-gray-300" }} transition-transform hover:scale-95 active:scale-90 px-5 py-1.5 rounded-2xl hover:bg-orange-600/70 active:bg-orange-700/70 font-semibold text-xl">
        {{ $profile->name }}
        <p class="text-white text-xs">Standing height : {{ $profile->standing_height }} cm</p>
        <p class="text-white text-xs">Sitting height : {{ $profile->sitting_height }} cm</p>
        <p class="text-white text-xs">Session length : {{$profile->session_length}} min</p>
    </button>
</form>
