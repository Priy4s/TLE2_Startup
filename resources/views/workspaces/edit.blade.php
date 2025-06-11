<x-nav>
    <h1>Bewerk workspace</h1>
    <form method="POST" action="{{ route('workspaces.update', $workspace) }}">
        @csrf
        @method('PUT')
        <label for="name">Naam:</label>
        <input type="text" name="name" value="{{ $workspace->name }}" required>
        <button type="submit">Opslaan</button>
    </form>
</x-nav>