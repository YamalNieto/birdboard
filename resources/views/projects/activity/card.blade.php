<x-card class="mt-3">
    <ul class="text-sm list-reset">
        @foreach($project->activity as $activity)
            <li class="{{ $loop->last ? '' : 'mb-1' }}">
                @include("projects.activity.$activity->description")
                <span class="text-gray-500">{{ $project->created_at->diffForHumans(null, false) }}</span>
            </li>
        @endforeach
    </ul>
</x-card>
