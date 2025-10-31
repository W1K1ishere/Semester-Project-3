@props([
  'href' => '#',
  'src'  => '',
  'alt'  => '',
  'size' => 8,
])

<a href="{{ $href }}" target="_blank"
    {{ $attributes->merge(['class' => 'inline-block hover:opacity-50 transition']) }}>
    <img src="{{ asset($src) }}"
         alt="{{ $alt }}"
         class="h-{{ $size }} w-{{ $size }}">
</a>
