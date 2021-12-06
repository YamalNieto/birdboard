<x-app-layout>
{{--    <x-slot name="header">--}}
{{--       <div class="flex items-center mb-3">--}}
{{--           <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-auto">--}}
{{--               Projects--}}
{{--           </h2>--}}
{{--           <h2><a href="/projects/create">New Project</a></h2>--}}
{{--       </div>--}}
{{--    </x-slot>--}}

   <div class="container max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
{{--   <div class="container mx-auto py-4">--}}
       <header class="flex items-center mb-3 py-4">
           <div class="flex justify-between items-center w-full">
               <h2 class="text-gray-500 font-normal">My projects</h2>
               {{--           <h2><a href="/projects/create">New Project</a></h2>--}}
               <x-button-blue>New Project</x-button-blue>
           </div>
       </header>

       <main class="max-w-7xl lg:flex lg:flex-wrap -mx-3">
           @forelse ($projects as $project)
               <div class="lg:w-1/3 px-3 pb-6">
                   <div class="bg-white p-5 rounded-xl shadow" style="height: 200px">
                       <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 pl-4" style="border-color: lightskyblue"><a href="{{ $project->path() }}">{{ $project->title }}</a></h3>

                       <div class="text-gray-500">{{ \Illuminate\Support\Str::limit($project->description, 50) }}</div>
                   </div>
               </div>
           @empty
               <div>No projects yet</div>
           @endforelse
       </main>
   </div>
</x-app-layout>
