@php
    $userName = $activity->user == auth()->user() ? 'You' : $activity->user->name;
@endphp

{{ $userName }} created a project
