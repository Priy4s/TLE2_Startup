<x-nav>
    <h1 class="text-6xl font-bold">Your Documents</h1>
    <div class="mt-10">
        <div class="flex justify-between w-full">
            <div>
                <form method="GET" action="{{ route('documents.overview') }}" class="mb-4 flex gap-2 items-center">
                    <input type="text" name="search" placeholder="Search documents..." value="{{ request('search') }}"
                           class="px-4 py-2 border-gray-300 dark:border-gray-700 dark:bg-articleBlue dark:text-viridian focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-[44vw]">
                    <button type="submit" class="px-4 py-2 rounded-md bg-articleBlue hover:bg-accentGreen text-viridian hover:text-greenLight dark:bg-accentBlue dark:hover:bg-accentGreen dark:text-greenLight">Search</button>
                </form>

                {{-- Filter buttons --}}
                <div id="filter-container" class="mb-4 flex flex-wrap items-center gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Filter:</span>
                    @php
                        $filterOptions = ['document', 'powerpoint', 'excel', 'form', 'pdf', 'google', 'microsoft', 'local'];
                        $baseClass = 'px-3 py-1 text-sm font-medium rounded-full cursor-pointer transition';
                        $activeClass = 'bg-accentGreen text-greenLight dark:bg-articleBlue dark:text-viridian';
                        $inactiveClass = 'bg-articleBlue text-viridian dark:bg-accentBlue dark:text-articleBlue hover:bg-accentGreen dark:hover:bg-accentGreen';
                    @endphp

                    <button data-filter="all" class="{{ $baseClass }} {{ empty($activeFilters) ? $activeClass : $inactiveClass }}">
                        All
                    </button>

                    @foreach ($filterOptions as $filter)
                        <button data-filter="{{ $filter }}"
                                class="{{ $baseClass }} {{ in_array($filter, $activeFilters ?? []) ? $activeClass : $inactiveClass }}">
                            {{ ucfirst($filter) }}
                        </button>
                    @endforeach
                </div>
            </div>

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
        <div>
            <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-[2vw]">
                @forelse($files as $file)
                    <li class="bg-articleBlue dark:bg-accentBlue p-4 rounded shadow relative w-[18vw] flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            @if ($file->provider === 'local')
                                {{-- Veilige link voor lokale bestanden --}}
                                <a href="{{ route('documents.serve.local', $file->id) }}" target="_blank" aria-label="{{ $file->name }}" class="max-w-[12vw] overflow-hidden overflow-ellipsis whitespace-nowrap text-viridian hover:text-accentBlue dark:text-greenLight dark:hover:text-articleBlue">
                                    {{ $file->name }} {{-- De zichtbare tekst van de link --}}
                                </a> {{-- Correcte sluiting van de link --}}
                            @else
                                {{-- Directe link voor cloud-bestanden --}}
                                <a href="{{ $file->web_view_link }}" target="_blank" aria-label="{{ $file->name }}" class="max-w-[12vw] overflow-hidden overflow-ellipsis whitespace-nowrap text-viridian hover:text-accentBlue dark:text-greenLight dark:hover:text-articleBlue">
                                    {{ $file->name }} {{-- De zichtbare tekst van de link --}}
                                </a> {{-- Correcte sluiting van de link --}}
                            @endif
                            <div class="w-5 flex justify-between mr-1">
                                @if($file->mime_type == 'application/vnd.google-apps.spreadsheet')
                                    <img src="{{ asset('images/sheets.png') }}" alt="Google_Sheets"/>
                                @elseif($file->mime_type == 'application/vnd.openxmlformats-officedocument.presentationml.presentation' || $file->mime_type == 'application/vnd.google-apps.presentation')
                                    <img src="{{ asset('images/slides.png') }}" alt="Google_Slides"/>
                                @elseif($file->mime_type == 'application/vnd.google-apps.form')
                                    <img src="{{ asset('images/forms.png') }}" alt="Google_Forms"/>
                                @elseif($file->mime_type == 'application/vnd.google-apps.document')
                                    <img src="{{ asset('images/docs.png') }}" alt="Google_Docs"/>
                                @elseif($file->mime_type == 'application/pdf')
                                    <img src="{{ asset('images/pdf.png') }}" alt="File_PDF"/>
                                @else
                                    <img src="{{ asset('images/other.png') }}" alt="File_Other"/>
                                @endif
                            </div>
                        </div>

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
    </div>

    {{-- Upload Modal --}}
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

{{-- Scripts --}}
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

        if (file && file.size > 10 * 1024 * 1024) {
            info.textContent = 'File is bigger than 10 MB. Please select a smaller file.';
            this.value = '';
        } else if (file) {
            info.textContent = `Selected file: ${file.name} (${(file.size / (1024 * 1024)).toFixed(2)} MB)`;
        } else {
            info.textContent = '';
        }
    });
</script>

