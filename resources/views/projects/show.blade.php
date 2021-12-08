<x-app-layout>
    <div class="container max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
        {{--   <div class="container mx-auto py-4">--}}
        <header class="flex items-center mb-3 py-4">
            <div class="flex justify-between items-end w-full">
                <p class="text-gray-500 font-normal">
                    <a href="/projects" class="ext-gray-500 font-normal no-underline">My projects</a> / {{ $project->title }}
                </p>
                <x-button-blue>New Project</x-button-blue>
            </div>
        </header>

        <main>
            <div class="lg:flex -mx-3">
                <div class="lg:w-3/4 px-3 mb-6">
                    <div class="mb-8">
                        <h2 class="text-lg text-gray-500 font-normal mb-3">Tasks</h2>
                        @foreach($project->tasks as $tasks)
                            <x-card class="mb-3">{{ $tasks->body }}</x-card>
                        @endforeach
                        <x-card>Lorem Ipsum</x-card>
                    </div>

                    <div>
                        <h2 class="text-lg text-gray-500 font-normal mb-3">General notes</h2>
                        <textarea class="w-full bg-white p-5 rounded-xl shadow" style="min-height: 200px">Lorem Ipsum</textarea>
                    </div>
                </div>

                <div class="lg:w-1/4 px-3">
                    @include('projects.partials.card-project')
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
