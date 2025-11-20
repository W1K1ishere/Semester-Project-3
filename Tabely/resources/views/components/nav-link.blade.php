@props(['active' => false,])

<a class="{{ $active ? "font-bold" : "font-medium" }} text-center text-xs text-black hover:bg-gray-200 rounded-md px-3 py-2"
   {{ $attributes }}>
    {{ $slot }}
</a>
