<x-nav>
    <h1>{{ $workspace->name }}</h1>
    <p>Dit is de detailpagina voor workspace "{{ $workspace->name }}"</p>
    <p>Hier kan je in de toekomst verder informatie specifiek per workspace invullen (zie vieuws/workspaces/show.blade.php)</p>

    <a href="{{ route('workspaces.index') }}">Terug naar overzicht</a>

    <!-- Notes Section -->
    <div class="mt-8">
        <h2 class="text-xl font-semibold mb-2">Notities</h2>

        <!-- Add Note Form -->
        <form action="{{ route('notes.store') }}" method="POST" class="mb-4">
            @csrf
            <input type="hidden" name="workspace_id" value="{{ $workspace->id }}">
            <textarea name="content" rows="3" class="w-full border rounded p-2" placeholder="Schrijf een notitie..." required></textarea>
            <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Notitie toevoegen</button>
        </form>

        <!-- Notes List -->
        @if($workspace->notes->count())
            <ul class="space-y-2">
                @foreach($workspace->notes as $note)
                    <li class="border p-3 rounded flex justify-between items-center">
                        <span>{{ $note->content }}</span>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Verwijder</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 mt-2">Er zijn nog geen notities voor deze workspace.</p>
        @endif
    </div>

    <ul>
        @foreach($workspace->cloudFiles as $file)
            <li>
                <a href="{{ $file->web_view_link }}" target="_blank">{{ $file->name }}</a>
                <form method="POST" action="{{ route('workspaces.removeDocument') }}" style="display:inline;">
                    @csrf
                    <input type="hidden" name="workspace_id" value="{{ $workspace->id }}">
                    <input type="hidden" name="cloudfile_id" value="{{ $file->id }}">
                    <button type="submit" class="text-red-500 hover:text-red-700">Remove</button>
                </form>
            </li>
        @endforeach
    </ul>
</x-nav>