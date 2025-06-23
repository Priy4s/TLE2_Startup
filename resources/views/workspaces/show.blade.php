<x-nav>
    <h1>{{ $workspace->name }}</h1>
    <p>Documents in this workspace:</p>
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
    <a href="{{ route('workspaces.index') }}">Back to Workspaces</a>
</x-nav>