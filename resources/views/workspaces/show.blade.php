<x-nav>
    <h1>{{ $workspace->name }}</h1>
    <p>Dit is de detailpagina voor workspace "{{ $workspace->name }}"</p>
    <p>Hier kan je in de toekomst verder informatie specifiek per workspace invullen (zie vieuws/workspaces/show.blade.php)</p>

    <a href="{{ route('workspaces.index') }}">Terug naar overzicht</a>
</x-nav>