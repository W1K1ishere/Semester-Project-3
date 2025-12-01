@php use App\Models\User; @endphp
@props(['active' => false, 'table',])

<div class="flex flex-col w-[calc(66%)] items-center rounded-3xl py-1 px-2 {{ $active ? 'bg-orange-500/70' : 'bg-white/70' }}">
    <label>{{ $table->desk_mac }} <small>Assigned:{{ $table->user_id == null ? 'No' : User::find($table->user_id)->name }}</small></label>
    <div class="flex flex-row justify-between px-4 w-full">
        <form method="POST" action="/admin/tables/select" class="contents">
            @csrf
            <input id="table_id" name="table_id" type="hidden" value="{{ $table->id }}">
            <button type="submit" class="text-xs hover:text-orange-500 hover:scale-95 {{ $active ? 'text-white' : 'text-black' }}">Edit</button>
        </form>
        <form method="POST" class="contents" action="/admin/tables/delete">
            @csrf
            @method('DELETE')
            <input id="table_id" name="table_id" type="hidden" value="{{ $table->id }}">
            <button type="submit" class="text-xs hover:text-orange-500 hover:scale-95 {{ $active ? 'text-white' : 'text-black' }}">Delete</button>
        </form>
    </div>
</div>
