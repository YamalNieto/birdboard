<x-card class="mt-3">
    <div class="card flex flex-col">
        <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 pl-4" style="border-color: lightskyblue">
            Invite a user
        </h3>

        <form action="{{ $project->path() . "/invitations" }}" method="POST">
            @csrf

            <div class="mb-3">
                <input type="email"
                       name="email"
                       class="border border-grey-light rounded w-full py-2 px-3"
                       placeholder="Email address"
                >

                @error('email')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <x-button-blue type="submit">Invite</x-button-blue>
        </form>
    </div>
</x-card>
