<x-app-layout>
    <div class="container max-w-7xl mx-auto sm:px-6 lg:px-8 py-4">
        <form action="/projects"
              method="POST"
              class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
            @csrf

            <h1 class="text-2xl font-normal mb-10 text-center">
                Create a new project
            </h1>

            <div class="field mb-6">
                <label for="title"
                       class="label text-sm mb-2 block"
                >Title
                </label>

                <div class="control">
                    <input type="text"
                           class="input bg-transparent border border-gray-light rounded p-2 text-sm w-full"
                           name="title"
                           id="title"
                           placeholder="My next awesome project"
                           required
                    >

                    @error('title')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="field mb-6">
                <label for="description"
                       class="label text-sm mb-2 block"
                >Description
                </label>

                <div class="control">
                    <textarea
                        class="textarea bg-transparent border border-gray-light rounded p-2 text-sm w-full"
                        name="description"
                        rows="10"
                        placeholder="I should start learning piano"
                        required
                    ></textarea>

                    @error('description')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <x-button-blue type="submit" class="mr-2">Create Project</x-button-blue>
                    <a href="/projects">Go Back</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
