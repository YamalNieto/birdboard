@php
    $userName = $activity->user == auth()->user() ? 'You' : $activity->user->name;
@endphp

{{ $userName }} completed "{{ $activity->subject->body }}"
