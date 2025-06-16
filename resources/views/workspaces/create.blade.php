<x-nav>
    <h1 class="text-6xl font-bold">Nieuwe Workspace</h1>
    <div class="mt-10">
        <form method="POST" action="{{ route('workspaces.store') }}" class="flex flex-col">
            @csrf
            <label for="name" class="text-viridian dark:text-greenLight">Naam:</label>
            <input type="text" name="name" required id="name" class="text-viridian">
            <button type="submit">Aanmaken</button>
        </form>
    </div>
</x-nav>