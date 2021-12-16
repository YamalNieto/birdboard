@php
    $userName = $activity->user == auth()->user() ? 'You' : $activity->user->name;
@endphp

@if (count($activity->changes['after']) == 1)
    {{ $userName }} updated the {{ key($activity->changes['after']) }} of the project
@else
    {{ $userName }} updated the project
@endif
