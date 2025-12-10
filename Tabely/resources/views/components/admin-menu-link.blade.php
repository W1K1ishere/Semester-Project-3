@props(['active' => false])

<a {{ $attributes->class([ 'w-full text-center py-3 rounded-3xl hover:scale-95 active:scale-90 transition-transform', 'bg-white/70 text-black hover:bg-gray-100/70 active:bg-gray-200/70' => ! $active, 'bg-orange-500/70 text-white hover:bg-orange-600/70 active:bg-orange-700/70' => $active]) }}>
    {{ $slot }}
</a>
