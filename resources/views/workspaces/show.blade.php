<x-nav>
<h1>{{ $workspace->name }}</h1>
<p>Documents in this workspace:</p>
<ul>
    @foreach($workspace->cloudFiles as $file)
        <li>
            <a href="{{ $file->web_view_link }}" target="_blank">{{ $file->name }}</a>
        </li>
    @endforeach
</ul>
<a href="{{ route('workspaces.index') }}">Back to Workspaces</a>
</x-nav>