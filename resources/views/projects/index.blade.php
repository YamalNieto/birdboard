<x-app-layout>

   <div class="container max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
       <header class="flex items-center mb-3 py-4">
           <div class="flex justify-between items-end w-full">
               <h2 class="text-gray-500 font-normal">My projects</h2>
               <a href="/projects/create"><x-button-blue>New Project</x-button-blue></a>
           </div>
       </header>

       <main class="max-w-7xl lg:flex lg:flex-wrap -mx-3">
           @forelse ($projects as $project)
               <div class="lg:w-1/3 px-3 pb-6">
                   <x-card style="height:200px">
                       <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 pl-4" style="border-color: lightskyblue"><a href="{{ $project->path() }}">{{ $project->title }}</a></h3>

                       <div class="text-gray-500">{{ $project->description }}</div>

                       <footer>
                           <form method="POST" action="{{ $project->path() }}" class="text-right">
                               @csrf
                               @method('delete')

                                <button class="text-sm" type="submit">Delete</button>
                           </form>
                       </footer>
                   </x-card>
               </div>
           @empty
               <div>No projects yet</div>
           @endforelse
       </main>
   </div>
</x-app-layout>
