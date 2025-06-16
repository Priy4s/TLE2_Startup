<x-nav>
    <h1 class="text-6xl font-bold">Workspaces</h1>
    <a class="underline text-lg text-accentBlue dark:text-articleBlue hover:text-viridian dark:hover:text-accentGreen rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('workspaces.create') }}">Nieuwe workspace maken</a>

    <ul>
        @foreach($workspaces as $workspace)
            <li>
                <a href="{{ route('workspaces.show', $workspace) }}">
                    {{ $workspace->name }}
                </a>
                <a href="{{ route('workspaces.edit', $workspace) }}">Bewerken</a>
                <form method="POST" action="{{ route('workspaces.destroy', $workspace) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Verwijderen</button>
                </form>
            </li>
        @endforeach
    </ul>
</x-nav>