<x-nav></x-nav>

<div class="p-4 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Documents</h1>

    <!-- Search Form -->
    <form method="GET" action="{{ route('documents.overview') }}" class="mb-4 flex gap-2 items-center">
        <input type="text" name="search" placeholder="Search documents..." value="{{ request('search') }}"
               class="border rounded px-4 py-2 flex-grow">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Search</button>
    </form>

    <!-- Sync Google Button -->
    <a href="{{ route('documents.overview', ['sync_google' => 1]) }}"
       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded mb-4 inline-block">
        🔄 Sync Google Drive
    </a>

    @if($lastSyncedAt)
        <p class="text-sm text-gray-600 mb-4">
            Last synced: {{ \Carbon\Carbon::parse($lastSyncedAt)->format('H:i d-m-Y') }}
        </p>
    @else
        <p class="text-sm text-gray-600 mb-4">
            Last synced: Never
        </p>
    @endif

    <div class="p-4 max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold mb-2">Documents</h1>

        <!-- Upload Form -->
        <form method="POST" action="{{ route('documents.upload') }}" enctype="multipart/form-data" class="mb-6">
            @csrf
            <input type="file" name="file" id="file" required class="border rounded px-2 py-1 mr-2">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Upload File (Max 10 MB)
            </button>
            <p id="file-info" class="mt-2 text-sm text-gray-700"></p>
        </form>

        @if(session('status'))
            <div class="mb-4 text-green-600 font-semibold">{{ session('status') }}</div>
        @endif

        <!-- Documents List -->
        <ul>
            @forelse($files as $file)
                @if($file->web_view_link)
                    <li class="mb-2">
                        <a href="{{ $file->web_view_link }}" target="_blank" class="text-blue-600 hover:underline">
                            {{ $file->name }}
                        </a>
                        <span class="ml-2 text-sm text-gray-500">[{{ ucfirst($file->provider) }}]</span>
                    </li>
                @endif
            @empty
                <li>No documents found.</li>
            @endforelse
        </ul>
    </div>
</div>

<!-- File Size Script -->
<script>
    document.getElementById('file').addEventListener('change', function () {
        const file = this.files[0];
        const info = document.getElementById('file-info');

        if (file) {
            const sizeMB = (file.size / (1024 * 1024)).toFixed(2);
            const maxMB = 10;
            info.textContent = `Selected file size: ${sizeMB} MB (Max allowed: ${maxMB} MB)`;

            if (file.size > maxMB * 1024 * 1024) {
                info.classList.remove('text-gray-700', 'text-green-600');
                info.classList.add('text-red-600');
            } else {
                info.classList.remove('text-gray-700', 'text-red-600');
                info.classList.add('text-green-600');
            }
        } else {
            info.textContent = '';
        }
    });
</script>
