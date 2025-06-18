<x-nav></x-nav>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h1 class="text-2xl font-bold mb-4">Your Documents</h1>

                {{-- Het zoekformulier blijft een standaard formulier --}}
                <form method="GET" action="{{ route('documents.overview') }}" class="mb-4 flex gap-2 items-center">
                    <input type="text" name="search" placeholder="Search documents..." value="{{ $currentSearch ?? '' }}"
                           class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm flex-grow">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Search</button>
                </form>

                @if(Auth::user()->google_refresh_token || Auth::user()->microsoft_refresh_token)
                    <a href="{{ route('documents.overview', ['sync_all' => 1]) }}"
                       class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded mb-4 inline-block">
                        🔄 Sync All Accounts
                    </a>
                @endif

                {{-- Filterknoppen --}}
                <div id="filter-container" class="mb-4 flex flex-wrap items-center gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Filter:</span>
                    @php
                        $filterOptions = ['google', 'microsoft', 'word', 'powerpoint', 'pdf'];
                        $baseClass = 'px-3 py-1 text-sm font-medium rounded-full cursor-pointer transition';
                        $activeClass = 'bg-blue-600 text-white';
                        $inactiveClass = 'bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-600';
                    @endphp

                    {{-- 'Alles' knop --}}
                    <button data-filter="all" class="{{ $baseClass }} {{ empty($activeFilters) ? $activeClass : $inactiveClass }}">
                        Alles
                    </button>

                    {{-- Dynamische filterknoppen --}}
                    @foreach ($filterOptions as $filter)
                        <button data-filter="{{ $filter }}"
                                class="{{ $baseClass }} {{ in_array($filter, $activeFilters ?? []) ? $activeClass : $inactiveClass }}">
                            {{ ucfirst($filter) }}
                        </button>
                    @endforeach
                </div>

                @if(session('status'))
                    <div class="mb-4 text-green-600 font-semibold">{{ session('status') }}</div>
                @endif

                {{-- Documentenlijst (ongewijzigd) --}}
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
                        <li class="text-gray-500 mt-4">No documents found.</li>
                    @endforelse
                </ul>

            </div>
        </div>
    </div>
</div>

{{-- Plaats dit script onderaan je view, of in een @push('scripts') sectie --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterContainer = document.getElementById('filter-container');

        if (filterContainer) {
            filterContainer.addEventListener('click', function (e) {
                // Reageer alleen op klikken op een knop met een data-filter attribuut
                const button = e.target.closest('button[data-filter]');
                if (!button) return;

                const clickedFilter = button.dataset.filter;

                // Haal de huidige URL en zijn parameters op
                const currentUrl = new URL(window.location.href);
                const params = currentUrl.searchParams;

                // Haal de lijst van actieve filters op
                let activeFilters = params.getAll('filters[]');

                if (clickedFilter === 'all') {
                    // Als op 'Alles' wordt geklikt, verwijder alle filters
                    params.delete('filters[]');
                } else {
                    const index = activeFilters.indexOf(clickedFilter);
                    if (index > -1) {
                        // Filter is al actief, dus verwijder het
                        activeFilters.splice(index, 1);
                    } else {
                        // Filter is niet actief, dus voeg het toe
                        activeFilters.push(clickedFilter);
                    }

                    // Werk de URL parameters bij
                    params.delete('filters[]'); // Verwijder de oude lijst
                    if (activeFilters.length > 0) {
                        activeFilters.forEach(filter => {
                            params.append('filters[]', filter);
                        });
                    }
                }

                // Navigeer naar de nieuwe URL
                window.location.href = currentUrl.toString();
            });
        }
    });
</script>