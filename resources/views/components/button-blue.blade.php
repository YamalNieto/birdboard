@php
    $classes = "text-white no-underline rounded-lg text-sm py-2 px-5 shadow ";
    if($attributes['class']) $classes .= $attributes['class'];
@endphp

<button class="{{ $classes }}" style="background-color: lightskyblue">
    {{ $slot }}
</button>
