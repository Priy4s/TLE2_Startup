<x-nav></x-nav>

<div class="p-4">
    <h1 class="text-2xl font-bold">Documents</h1>
    <a href="{{ route('documents.overview', ['sync' => 1]) }}"
       class="bg-blue-500 text-white px-4 py-2 rounded mb-4 inline-block">
        🔄 Sync     <p class="text-gray-600 mb-2">Last Synced: {{ $files->isNotEmpty() ? $files->first()->synced_at->format('H:i:s d-m-Y') : 'Never' }}</p>
    </a>
    <ul>
        @foreach($files as $file)
            <li class="my-2">
                <a href="{{ $file['webViewLink'] }}" target="_blank" class="text-blue-500">
                    {{ $file['name'] }}
                </a>
                <p>Type: {{ $file['mimeType'] }}</p>
            </li>
        @endforeach
    </ul>
</div>