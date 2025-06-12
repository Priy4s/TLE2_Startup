<x-nav></x-nav>

<div class="p-4">
    <h1 class="text-2xl font-bold">Documents</h1>
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