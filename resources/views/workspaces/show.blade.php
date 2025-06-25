<x-nav>
        <h1 class="text-6xl font-bold">{{ $workspace->name }}</h1>
    <div class="mt-10">
        <div class="flex">
            <div class="w-[40vw]">
                <h2 class="text-2xl font-bold mb-2">Documents</h2>
                <ul>
                    @forelse($workspace->cloudFiles as $file)
                        <li class="bg-articleBlue dark:bg-accentBlue p-3 rounded flex justify-between items-center mb-2">
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
                            <div class="flex">
                                <div class="w-5 flex justify-between mr-4">
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
                                <form method="POST" action="{{ route('workspaces.removeDocument') }}" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="workspace_id" value="{{ $workspace->id }}">
                                    <input type="hidden" name="cloudfile_id" value="{{ $file->id }}">
                                    <button type="submit" class="dark:text-red-200 text-red-600 hover:underline">Delete</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <p class="text-accentGreen dark:text-articleBlue">Add documents to this workspace through the documents tab, they'll show up here</p>
                    @endforelse
                </ul>
            <!-- Notes Section -->
                <div class="mt-12">
                    <!-- Modal Structure -->
                    <div id="noteModal" class="fixed inset-0 bg-viridian bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-articleBlue dark:bg-accentBlue text-viridian dark:text-greenLight w-full max-w-md p-6 rounded shadow-lg relative">
                            <h2 class="text-xl font-semibold mb-4">New Note</h2>

                            <form action="{{ route('notes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="workspace_id" value="{{ $workspace->id }}">
                                <textarea name="content" rows="3" class="w-full border rounded p-2 text-viridian bg-greenLight" placeholder="Start writing note..." required></textarea>
                                <div class="flex justify-end mt-4 space-x-2">
                                    <button type="button" id="closeModalBtn" class="px-4 py-2 bg-accentGreen text-greenLight rounded">Cancel</button>
                                    <x-primary-button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Add Note</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Notes List -->
                    <h2 class="text-2xl font-bold mb-2">Notes</h2>
                    @if($workspace->notes->count())
                        <ul class="space-y-2">
                            @foreach($workspace->notes as $note)
                                <li class="bg-articleBlue dark:bg-accentBlue p-3 rounded flex justify-between items-center">
                                    <p class="text-viridian dark:text-greenLight max-w-[32vw] break-words">{{ $note->content }}</p>
                                    <form action="{{ route('notes.destroy', $note) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dark:text-red-200 text-red-600 hover:underline">Delete</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-accentGreen dark:text-articleBlue mt-2">Make a new note, it will show up here.</p>
                    @endif
                </div>

                <!-- Links Section -->
                <div class="mt-12">
                    <!-- Modal Structure -->
                    <div id="linkModal" class="fixed inset-0 bg-viridian bg-opacity-50 flex items-center justify-center z-50 hidden">
                        <div class="bg-articleBlue dark:bg-accentBlue text-viridian dark:text-greenLight w-full max-w-md p-6 rounded shadow-lg relative">
                            <h2 class="text-xl font-semibold mb-4">New Link</h2>

                            <form action="{{ route('links.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="workspace_id" value="{{ $workspace->id }}">

                                <input type="url" name="url" class="w-full border rounded p-2 mb-2 text-viridian bg-greenLight" placeholder="https://example.com" required>
                                <input type="text" name="label" class="w-full border rounded p-2 text-viridian bg-greenLight" placeholder="Give your link a title">

                                <div class="flex justify-end mt-4 space-x-2">
                                    <button type="button" id="closeLinkModalBtn" class="px-4 py-2 bg-accentGreen text-greenLight rounded">Cancel</button>
                                    <x-primary-button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Add Link</x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Show Existing Links -->
                    <h2 class="text-2xl font-bold mb-2">Links</h2>
                    @if($workspace->links->count())
                        <ul class="space-y-2">
                            @foreach($workspace->links as $link)
                                <li class="p-3 rounded flex justify-between items-center bg-articleBlue dark:bg-accentBlue">
                                    <a href="{{ $link->url }}" target="_blank" class="text-viridian dark:text-greenLight hover:underline">
                                        {{ $link->label ?? $link->url }}
                                    </a>
                                    <form action="{{ route('links.destroy', $link) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dark:text-red-200 text-red-600 hover:underline">Delete</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-accentGreen dark:text-articleBlue mt-2">Add a new link, it will show up here.</p>
                    @endif
                </div>
                <div class="fixed bottom-6 right-6 z-50" id="fabContainer">
                    <div id="fabMenu" class="hidden mb-2 space-y-2 text-left flex flex-col bg-accentGreen rounded">
                        <button id="fabAddNote" class="px-4 py-2 text-greenLight rounded hover:bg-accentBlue">Add Note</button>
                        <button id="fabAddLink" class="px-4 py-2 text-greenLight rounded hover:bg-accentBlue">Add Link</button>
                    </div>

                    <button id="fabToggle" class="w-14 h-14 rounded-full bg-accentGreen text-greenLight text-3xl shadow-lg flex items-center align-middle justify-center hover:bg-accentBlue">
                        +
                    </button>
                </div>
            </div>

            <!-- Calendar items -->
            <div class="ml-8">
                <h2 class="text-2xl font-bold mb-2">Events</h2>
                @if($events->count())
                    <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                        @foreach($events as $event)
                            <li class="bg-articleBlue dark:bg-accentBlue text-viridian dark:text-greenLight p-3 rounded flex flex-col items-center max-w-[12vw]">
                                <div class="text-2xl font-bold pb-1">
                                    {{ \Carbon\Carbon::parse($event->date)->format('F') }}
                                </div>
                                <div class="text-5xl pb-2">
                                    {{ \Carbon\Carbon::parse($event->date)->format('j') }}
                                </div>
                                <div>
                                    {{ $event->event }}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-accentGreen dark:text-articleBlue mt-2">Link events to the workspace through the calendar, they'll show up here.</p>
                @endif
            </div>

        </div>
    </div>

</x-nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const openBtn = document.getElementById('openModalBtn');
        const modal = document.getElementById('noteModal');
        const closeBtn = document.getElementById('closeModalBtn');

        // Open modal
        openBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        // Close modal
        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Close modal when clicking outside the modal content
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const openLinkBtn = document.getElementById('openLinkModalBtn');
        const linkModal = document.getElementById('linkModal');
        const closeLinkBtn = document.getElementById('closeLinkModalBtn');

        // Open Link Modal
        openLinkBtn.addEventListener('click', () => {
            linkModal.classList.remove('hidden');
        });

        // Close Link Modal
        closeLinkBtn.addEventListener('click', () => {
            linkModal.classList.add('hidden');
        });

        // Close when clicking outside the modal box
        window.addEventListener('click', (e) => {
            if (e.target === linkModal) {
                linkModal.classList.add('hidden');
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        // Existing modal logic...

        // Floating Action Button (FAB) Logic
        const fabToggle = document.getElementById('fabToggle');
        const fabMenu = document.getElementById('fabMenu');
        const fabAddNote = document.getElementById('fabAddNote');
        const fabAddLink = document.getElementById('fabAddLink');

        // Toggle the dropdown menu
        fabToggle.addEventListener('click', () => {
            fabMenu.classList.toggle('hidden');
        });

        // Click "Add Note" from FAB
        fabAddNote.addEventListener('click', () => {
            document.getElementById('noteModal').classList.remove('hidden');
            fabMenu.classList.add('hidden');
        });

        // Click "Add Link" from FAB
        fabAddLink.addEventListener('click', () => {
            document.getElementById('linkModal').classList.remove('hidden');
            fabMenu.classList.add('hidden');
        });

        // Optional: Hide menu when clicking anywhere else
        document.addEventListener('click', function (event) {
            if (!document.getElementById('fabContainer').contains(event.target)) {
                fabMenu.classList.add('hidden');
            }
        });
    });
</script>
