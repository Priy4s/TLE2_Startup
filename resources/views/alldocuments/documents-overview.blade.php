<x-nav></x-nav>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h1 class="text-2xl font-bold mb-4">Your Documents</h1>

                    <form method="GET" action="{{ route('documents.overview') }}" class="mb-4 flex gap-2 items-center">
                        <input type="text" name="search" placeholder="Search documents..." value="{{ request('search') }}"
                               class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm flex-grow">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Search</button>
                    </form>

                    @if(Auth::user()->google_refresh_token || Auth::user()->microsoft_refresh_token)
                        <a href="{{ route('documents.overview', ['sync_all' => 1]) }}"
                           class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded mb-4 inline-block">
                            🔄 Sync All Accounts
                        </a>
                    @endif

                    @if($lastSyncedAt)
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Last synced: {{ \Carbon\Carbon::parse($lastSyncedAt)->format('d-m-Y H:i') }}
                        </p>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
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

                    @if ($errors->any())
                        <div class="mb-4 text-red-600 font-semibold">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <ul class="space-y-1">
                        @forelse($files as $file)
                            <li class="p-3 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                <a href="{{ $file->web_view_link }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $file->name }}
                                </a>
                                <span class="ml-4 text-xs font-semibold px-2 py-1 rounded-full
                                    @if($file->provider == 'google') bg-red-200 text-red-800 @elseif($file->provider == 'microsoft') bg-blue-200 text-blue-800 @else bg-gray-200 text-gray-800 @endif">
                                    {{ ucfirst($file->provider) }}
                                </span>
                            </li>
                        @empty
                            <li class="text-gray-500 mt-4">No documents found. Try connecting an account and syncing.</li>
                        @endforelse
                    </ul>

                </div>
            </div>
        </div>
    </div>
    </div>
