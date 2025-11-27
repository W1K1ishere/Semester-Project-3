@props(['text', 'value', 'id', 'name'])
<div class="gap-1">
    <p>{{ $name }}</p>
    <div>
        <button type="button" onclick="this.nextElementSibling.stepDown()">-</button>
        <input name="{{ $name }}" id="{{ $id }}" type="number" value="{{ $value }}" class="bg-transparent border-b-black border-b-2 text-center text-black [&::-webkit-inner-spin-button]:appearance-none &::-webkit-outer-spin-button]:appearance-none] appearance-none">
        <button type="button" onclick="this.previousElementSibling.stepUp()">+</button>
    </div>
</div>
