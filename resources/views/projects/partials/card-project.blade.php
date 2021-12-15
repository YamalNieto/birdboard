<x-card>
    <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 pl-4" style="border-color: lightskyblue"><a href="{{ $project->path() }}">{{ $project->title }}</a></h3>

    <div class="text-gray-500">{{ $project->description }}</div>
</x-card>
