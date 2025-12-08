@props(['href' => '#', 'src'  => '', 'alt'  => '', 'size' => 8])

<a href="{{ $href }}" target="_blank"
    {{ $attributes->merge(['class' => 'inline-block hover:opacity-50 hover:scale-95 transition-transform active:scale-90 active:opacity-50']) }}>
    <img src="{{ asset($src) }}" alt="{{ $alt }}" class="h-{{ $size }} w-{{ $size }}">
</a>
