@props(['active' => false, 'department'])

<form method="POST" action="{{ route('scheduler.select') }}">
    @csrf
    <input type="hidden" name="dep_id" value="{{ $department->id }}">

    <button type="submit" class="w-full text-left px-4 py-2 rounded-xl {{ $active ? 'text-white bg-orange-500' : 'text-black bg-gray-300' }}">
        <strong>{{ $department->dep_name }}</strong>
        <small>{{ $department->id }}</small>
    </button>
</form>
