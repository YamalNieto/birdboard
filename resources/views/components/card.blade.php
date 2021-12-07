@php
    $classes = "bg-white p-5 rounded-xl shadow ";
    if($attributes['class']) $classes .= $attributes['class'];
@endphp

<div class="{{ $classes }}" {{ $attributes }}>
    {{ $slot }}
</div>
