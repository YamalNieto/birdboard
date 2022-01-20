<x-card>
    <div class="card flex flex-col" style="height: 200px">
        <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 pl-4" style="border-color: lightskyblue">
            <a href="{{ $project->path() }}">{{ $project->title }}</a>
        </h3>

        <div class="text-gray-500 mb-4 flex-1">{{ $project->description }}</div>

        <footer>
            <form action="{{ $project->path() }}" method="post">
                @method('DELETE')
                @csrf
                <x-button-blue type="submit">Delete</x-button-blue>
            </form>
        </footer>
    </div>
</x-card>
