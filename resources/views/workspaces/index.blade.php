<x-nav>
    <h1>Workspaces</h1>
    <a href="{{ route('workspaces.create') }}">Nieuwe workspace maken</a>

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