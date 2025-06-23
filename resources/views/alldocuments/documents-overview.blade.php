<x-nav>
    <h1 class="text-6xl font-bold">Your Documents</h1>
    <div class="mt-10">
        <div class="flex justify-between w-full">
            <div>
                {{-- Zoekformulier --}}
                <form method="GET" action="{{ route('documents.overview') }}" class="mb-4 flex gap-2 items-center">
                    <input type="text" name="search" placeholder="Search documents..." value="{{ request('search') }}"
                           class="px-4 py-2 border-gray-300 dark:border-gray-700 dark:bg-articleBlue dark:text-viridian focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-[44vw]">
                    <button type="submit" class="px-4 py-2 rounded-md bg-articleBlue hover:bg-accentGreen text-viridian hover:text-greenLight dark:bg-accentBlue dark:hover:bg-accentGreen dark:text-greenLight">Search</button>
                </form>

                {{-- Filters --}}
                <div id="filter-container" class="mb-4 flex flex-wrap items-center gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Filter:</span>
                    @php
                        $filterOptions = ['google', 'microsoft', 'word', 'powerpoint', 'pdf', 'local'];
                        $baseClass = 'px-3 py-1 text-sm font-medium rounded-full cursor-pointer transition';
                        $activeClass = 'bg-blue-600 text-white';
                        $inactiveClass = 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600';
                    @endphp

                    <button data-filter="all" class="{{ $baseClass }} {{ empty($activeFilters) ? $activeClass : $inactiveClass }}">Alles</button>

                    @foreach ($filterOptions as $filter)
                        <button data-filter="{{ $filter }}"
                                class="{{ $baseClass }} {{ in_array($filter, $activeFilters ?? []) ? $activeClass : $inactiveClass }}">
                            {{ ucfirst($filter) }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Rechterzijde --}}
            <div class="text-right">
                @if(Auth::user()->google_refresh_token || Auth::user()->microsoft_refresh_token)
                    <a href="{{ route('documents.overview', ['sync_all' => 1]) }}"
                       class="w-[13vw] bg-articleBlue hover:bg-accentGreen text-viridian hover:text-greenLight dark:bg-accentBlue dark:hover:bg-accentGreen dark:text-greenLight text-center px-4 py-2 rounded mb-1 inline-block">
                        Sync Documents <i class="fa-solid fa-rotate ml-2"></i>
                    </a>
                @endif

                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                    Last synced: {{ $lastSyncedAt ? \Carbon\Carbon::parse($lastSyncedAt)->format('d-m-Y H:i') : 'Never' }}
                </p>

                <button onclick="openModal('upload-file')" class="w-[13vw] bg-articleBlue hover:bg-accentGreen text-viridian hover:text-greenLight dark:bg-accentBlue dark:hover:bg-accentGreen dark:text-greenLight px-4 py-2 rounded">
                    Upload File <i class="fa-solid fa-upload ml-2"></i>
                </button>

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
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-2">Documents</h2>

        {{-- Documentenlijst --}}
        <ul class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-[2vw]">
            @forelse($files as $file)
                <li class="bg-articleBlue dark:bg-accentBlue p-4 rounded shadow relative w-[24vw] flex flex-col justify-between">
                    <a href="{{ $file->web_view_link }}" target="_blank" class="break-words text-viridian hover:text-accentBlue dark:text-greenLight dark:hover:text-articleBlue mb-4">
                        {{ $file->name }}
                    </a>

                    <div class="flex justify-between items-center mb-2">
                        {{-- MIME type tag --}}
                        @if($file->mime_type == 'application/vnd.google-apps.spreadsheet')
                            <span class="text-xs bg-green-200 text-green-800 dark:bg-green-800 dark:text-green-100 font-semibold px-2 py-1 rounded-full">Sheets</span>
                        @elseif($file->mime_type == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' || $file->mime_type == 'application/vnd.google-apps.presentation')
                            <span class="text-xs bg-orange-200 text-orange-800 dark:bg-orange-800 dark:text-orange-100 font-semibold px-2 py-1 rounded-full">Slides</span>
                        @elseif($file->mime_type == 'application/vnd.google-apps.form')
                            <span class="text-xs bg-purple-200 text-purple-800 dark:bg-purple-800 dark:text-purple-100 font-semibold px-2 py-1 rounded-full">Forms</span>
                        @elseif($file->mime_type == 'application/vnd.google-apps.document')
                            <span class="text-xs bg-blue-200 text-blue-800 dark:bg-blue-900 dark:text-blue-100 font-semibold px-2 py-1 rounded-full">Docs</span>
                        @else
                            <span class="text-xs bg-gray-200 text-gray-800 dark:bg-gray-800 dark:text-gray-100 font-semibold px-2 py-1 rounded-full">Other</span>
                        @endif

                        {{-- Provider tag --}}
                        <span class="ml-2 text-xs font-semibold px-2 py-1 rounded-full
                            @if($file->provider == 'google') bg-red-200 text-red-800 dark:bg-red-900 dark:text-red-200
                            @elseif($file->provider == 'microsoft') bg-blue-200 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @else bg-gray-200 text-gray-800 dark:bg-gray-900 dark:text-gray-200 @endif">
                            {{ ucfirst($file->provider) }}
                        </span>
                    </div>

                    {{-- Toevoegen aan Workspace --}}
                    <form method="POST" action="{{ route('workspaces.addDocumentToSelected') }}">
                        @csrf
                        <input type="hidden" name="cloudfile_id" value="{{ $file->id }}">

                        <select name="workspace_id" class="w-full px-3 py-2 rounded border-gray-300 mb-2 dark:bg-articleBlue dark:text-viridian dark:border-gray-600">
                            @foreach($userWorkspaces as $ws)
                                <option value="{{ $ws->id }}">{{ $ws->name }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="bg-green-500 text-white px-3 py-2 rounded w-full text-sm hover:bg-green-600">
                            Add to Selected Workspace
                        </button>
                    </form>

                </li>
            @empty
                <li class="text-gray-500 mt-4">No documents found. Try connecting an account and syncing.</li>
            @endforelse
        </ul>
    </div>

    {{-- Modal: Upload File --}}
    <div id="modal-upload-file" class="fixed inset-0 flex items-center justify-center hidden z-50">
        <div class="absolute inset-0 bg-greenLight dark:bg-viridian bg-opacity-50 dark:bg-opacity-50" onclick="closeModal('upload-file')"></div>

        <div class="relative bg-articleBlue dark:bg-accentBlue p-6 rounded shadow-lg w-full max-w-md z-10">
            <button class="absolute top-2 right-2 text-viridian hover:text-accentGreen text-xl" onclick="closeModal('upload-file')">&times;</button>

            <h1 class="text-xl font-bold mb-4">Upload File (Max 10 MB)</h1>

            <form method="POST" action="{{ route('documents.upload') }}" enctype="multipart/form-data" class="mb-6">
                @csrf
                <label for="file" class="block text-sm font-medium text-viridian dark:text-greenLight mb-2">Select File</label>
                <input type="file" name="file" id="file" required class="border rounded px-2 py-1 w-full mb-4 bg-articleBlue text-viridian">

                <x-primary-button type="submit">Upload file</x-primary-button>

                <p id="file-info" class="mt-2 text-sm text-gray-700"></p>
            </form>
        </div>
    </div>
</x-nav>

{{-- JavaScript --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterContainer = document.getElementById('filter-container');

        if (filterContainer) {
            filterContainer.addEventListener('click', function (e) {
                const button = e.target.closest('button[data-filter]');
                if (!button) return;

                const clickedFilter = button.dataset.filter;
                const currentUrl = new URL(window.location.href);
                const params = currentUrl.searchParams;
                let activeFilters = params.getAll('filters[]');

                if (clickedFilter === 'all') {
                    params.delete('filters[]');
                } else {
                    const index = activeFilters.indexOf(clickedFilter);
                    if (index > -1) {
                        activeFilters.splice(index, 1);
                    } else {
                        activeFilters.push(clickedFilter);
                    }

                    params.delete('filters[]');
                    activeFilters.forEach(filter => params.append('filters[]', filter));
                }

                window.location.href = currentUrl.toString();
            });
        }
    });

    function openModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }
    document.getElementById('file').addEventListener('change', function () {
        const file = this.files[0];
        const info = document.getElementById('file-info');

        if (file && file.size > 10 * 1024 * 1024) { // 10 MB
            info.textContent = 'File is bigger than 10 MB. Please select a smaller file.';
            this.value = ''; // reset input
        } else if (file) {
            info.textContent = `Selected file: ${file.name} (${(file.size / (1024 * 1024)).toFixed(2)} MB)`;
        } else {
            info.textContent = '';
        }
    });

</script>
