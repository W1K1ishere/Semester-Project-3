@props(['active' => false, 'user',])

<div class="flex flex-col w-[calc(66%)] items-center rounded-3xl py-1 px-2 {{ $active ? 'bg-orange-500/70' : 'bg-white/70' }}">
    <label>{{ $user->name }} <small>ID: {{ $user->id }}</small></label>
    <div class="flex flex-row justify-between px-4 w-full">
        <form method="POST" action="/admin/users/select" class="contents">
            @csrf
            <input id="user_id" name="user_id" type="hidden" value="{{ $user->id }}">
            <button type="submit" class="text-xs hover:text-orange-500 hover:scale-95 {{ $active ? 'text-white' : 'text-black' }}">Edit</button>
        </form>
        <form method="POST" class="contents" action="/admin/users/delete">
            @csrf
            @method('DELETE')
            <input id="user_id" name="user_id" type="hidden" value="{{ $user->id }}">
            <button type="submit" class="text-xs hover:text-orange-500 hover:scale-95 {{ $active ? 'text-white' : 'text-black' }}">Delete</button>
        </form>
    </div>
</div>
