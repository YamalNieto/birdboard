<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <h1>Create a Project</h1>

    <form action="/projects" method="POST">
        @csrf

        <div class="mb-6">
            <label for="title"
                   class="block mb-2 uppercase font-bold text-xs text-gray-700">
                Title
            </label>

            <input type="text"
                   class="border border-gray-400 p-2 w-full"
                   name="title"
                   id="title"
                   required>

            @error('title')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description"
                   class="block mb-2 uppercase font-bold text-xs text-gray-700">
                Description
            </label>

            <textarea
                   class="border border-gray-400 p-2 w-full"
                   name="description"
                   id="description"
                   required></textarea>

            @error('description')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit">Create Project</button>
    </form>
</body>
</html>
