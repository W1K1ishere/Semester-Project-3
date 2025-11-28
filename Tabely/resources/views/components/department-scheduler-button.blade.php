@props(['active' => false, 'department'])

<form method="POST" action="{{ route('scheduler.select') }}">
    @csrf
    <input type="hidden" name="dep_id" value="{{ $department->id }}">

    <button type="submit" class="w-full text-center px-4 py-2 rounded-3xl
        hover:scale-95 transition-transform active:scale-90 {{ $active ? '' : 'bg-white/70 hover:bg-gray-100/70 active:bg-gray-200/70' }} {{ $active ? 'text-white bg-orange-500/70 hover: hover:bg-orange-600/70 active:bg-orange-700/70' : '' }}">
        <label>{{ $department->dep_name }}</label>
        <small>ID: {{ $department->id }}</small>
    </button>
</form>
