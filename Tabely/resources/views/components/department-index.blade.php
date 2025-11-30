@props(['active' => false, 'department',])

<div class="flex flex-col  w-[calc(66%)] rounded-3xl py-1 px-2 items-center gap-1 {{ $active ? 'bg-orange-500/70' : 'bg-white/70' }}">
    <label class="{{ $active ? 'text-white' : 'text-black' }}">{{ $department->dep_name }} <small>ID: {{ $department->id }}</small></label>
    <div class="flex flex-row justify-between px-4 w-full">
        <form method="POST" action="/admin/departments/select" class="contents">
            @csrf
            <input id="dep_id" name="dep_id" type="hidden" value="{{ $department->id }}">
            <button type="submit" class="text-xs hover:text-orange-500 hover:scale-95 {{ $active ? 'text-white' : 'text-black' }}">Edit</button>
        </form>
        <form method="POST" class="contents" action="/admin/departments/delete">
            @csrf
            @method('DELETE')
            <input id="dep_id" name="dep_id" type="hidden" value="{{ $department->id }}">
            <button type="submit" class="text-xs hover:text-orange-500 hover:scale-95 {{ $active ? 'text-white' : 'text-black' }}">Delete</button>
        </form>
    </div>
</div>
